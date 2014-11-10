<?php

namespace frontend\controllers;

use yii\data\Pagination;
use frontend\base\Controller;
use common\models\AnswerQuery;
use common\models\QuestionCommentQuery;
use common\models\Question;
use common\models\QuestionQuery;
use frontend\models\AnswerForm;
use frontend\models\QuestionForm;
use yii\db\Query;
use yii\web\HttpException;

class QuestionController extends Controller
{
    public function init()
    {
        parent::init();

        $this->channel = CHANNEL_QUESTION;
    }

    public function actionIndex($sort = null)
    {
        $query = static::buildQuestionQuery($sort);
        $pages = new Pagination(['totalCount' => $query->count()]);
        $pages->defaultPageSize = 15;
        $questions = static::fetchQuestions($query, $pages);

        return $this->render('index', [
            'tab_view' => '_question_tab',
            'sort' => $sort,
            'pages' => $pages,
            'questions' => $questions,
        ]);
    }

    public function actionAsk()
    {
        if (user()->getIsGuest())
            user()->loginRequired(false);

        $this->channel = 'ask_question';
        $model = new QuestionForm();

        if (request()->getIsPost() && $model->load(request()->post()) && $model->validate()) {
            if ($question = $model->save())
                $this->redirect($question->getUrl());
            else {
                //@todo 待处理
                var_dump($question->getErrors());
            }

        }
        else
            return $this->render('ask', ['model'=>$model]);
    }

    public function actionShow($id, $sort = TAB_ANSWER_SORT_ACTIVE)
    {
        $id = (int)$id;

        // get question with relation comments
        $question = Question::find()->with(['user',
            'comments' => function(QuestionCommentQuery $query){
                    $query->with(['user'])->orderBy(['created_at' => SORT_ASC]);
                },
        ])->where(['id' => $id])->one();

        // get answers pages instance
        $pages = new Pagination(['totalCount' => $question->getAnswers()->count()]);

        // get answers
        $answers = static::buildAnswerQuery($question->getAnswers(), $sort)
            ->limit($pages->limit)
            ->offset($pages->offset)
            ->with(['user', 'comments'])
            ->all();

        $answerForm = new AnswerForm();
        $answerForm->question_id = $id;

        return $this->render('show', [
            'question' => $question,
            'answers' => $answers,
            'pages' => $pages,
            'sort' => $sort,
            'answerForm' => $answerForm,
            'starClass' => static::buildFavoriteClass($question),
        ]);
    }

    private static function buildFavoriteClass($question)
    {
        if (user()->getIsGuest())
            return 'star-off';
        else {
            $exist = (new Query())->from(TBL_USER_QUESTION)
                ->where(['user_id' => user()->id, 'question_id' => $question->id])
                ->exists();

            return $exist ? 'star-off star-on' : 'star-off';
        }
    }

    public function actionUnanswered($sort = '')
    {
        $query = Question::find()->active()->where('answer_count = 0');
        $pages = new Pagination(['totalCount' => $query->count()]);
        $pages->defaultPageSize = 15;
        $questions = static::fetchQuestions($query, $pages);

        return $this->render('index', [
            'tab_view' => '_unanswered_tab',
            'sort' => $sort,
            'pages' => $pages,
            'questions' => $questions,
        ]);
    }

    public function actionVoteUp()
    {
        $id = (int)request()->post('id');
        static::ajaxVote($id, 'vote_up');
    }

    public function actionVoteDown()
    {
        $id = (int)request()->post('id');
        static::ajaxVote($id, 'vote_down');
    }

    private static function ajaxVote($id, $column, $step = 1)
    {
        if (user()->getIdentity()->profile->data_reputation < 15) {
            $data['errno'] = YES;
            $data['message'] = '需要至少15个威望才能评价';
        }
        else {
            $id = (int)$id;
            $question = Question::find()
                ->select(['id', 'vote_up', 'vote_down'])
                ->where('id = :question_id', [':question_id' => $id])
                ->one();
            $question->$column += (int)$step;
            $result = $question->save(true, [$column]);

            $data['errno'] = $result ? NO : YES;
            $data['vote_score'] = $result ? $question->getVoteScore() : 0;
        }

        echo json_encode($data);
        exit(0);
    }

    public function actionFavorite()
    {
        $id = (int)request()->post('id');
        $exist = Question::find()
            ->where('id = :question_id', [':question_id' => $id])
            ->exists();

        if ($exist) {
            $exist = (new Query())->from(TBL_USER_QUESTION)
                ->where(['user_id' => user()->id, 'question_id' => $id])
                ->exists();

            $columns = ['user_id' => user()->id, 'question_id' => $id];
            if ($exist) {
                db()->createCommand()->delete(TBL_USER_QUESTION, $columns)->execute();
                $data['errno'] = NO;
                $data['action'] = 'delete';
            }
            else {
                $result = db()->createCommand()->insert(TBL_USER_QUESTION, $columns)->execute();
                $data['errno'] = NO;
                $data['action'] = 'insert';
            }
        }
        else {
            $data['errno'] = YES;
            $data['message'] = '问题不存在，非法操作。';
        }

        echo json_encode($data);
        exit;
    }

    /***************************** fetch question list *****************************/

    private static function buildAnswerQuery(AnswerQuery $query, $sort)
    {
        switch ($sort)
        {
            case TAB_ANSWER_SORT_OLDEST:
                $query->orderBy(['created_at' => SORT_DESC]);
                break;
            case TAB_ANSWER_SORT_VOTES:
                $query->orderBy(['vote_up' => SORT_DESC]);
                break;
            case TAB_ANSWER_SORT_ACTIVE:
            default:
                $query->orderBy(['created_at' => SORT_ASC]);
                break;
        }

        return $query;
    }

    /***************************** fetch question list *****************************/

    private static function buildQuestionQuery($sort)
    {
        $query = Question::find()->active();
        switch ($sort)
        {
            case TAB_QUESTION_SORT_ACTIVE:
                $query->orderBy(['updated_at' => SORT_DESC]);
                break;
            case TAB_QUESTION_SORT_BOUNTY:
                $query->hasBounty()->orderBy(['open_bounty_end_time' => SORT_ASC]);
                break;
            case TAB_QUESTION_SORT_UNANSWERED:
                $query->unanswered()->orderBy(['vote_up' => SORT_DESC, 'created_at' => SORT_DESC]);
                break;
            case TAB_QUESTION_SORT_VOTES:
                $query->orderBy(['vote_up' => SORT_DESC]);
                break;
            case TAB_QUESTION_SORT_FREQUENT:
                //@todo 这个是最经常被提到的问题，开始不显示，后续问题多了，再添加。
            case TAB_QUESTION_SORT_NEWEST:
            default:
                $query->orderBy(['created_at' => SORT_DESC]);
                break;
        }

        return $query;
    }

    private static function fetchQuestions(QuestionQuery $query, Pagination $pages)
    {

        return $query->limit($pages->limit)->offset($pages->offset)->all();
    }

}
