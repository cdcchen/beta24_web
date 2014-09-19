<?php

namespace frontend\controllers;

use common\base\Pagination;
use frontend\base\Controller;
use common\models\AnswerQuery;
use common\models\QuestionCommentQuery;
use common\models\Question;
use common\models\QuestionQuery;
use frontend\models\AnswerForm;
use frontend\models\QuestionForm;
use yii\helpers\Url;

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

        $model = new QuestionForm();

        if (request()->getIsPost() && $model->load(request()->post()) && $model->validate()) {
            if ($question = $model->save())
                $this->redirect($question->getUrl());
            else {
                //@todo 待处理
                var_dump($question);
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
        ]);
    }

    public function actionCreateAnswer()
    {
        $answerForm = new AnswerForm();
        if (request()->getIsPost() && $answerForm->load(request()->post()) && $answerForm->validate()) {
            if ($answer = $answerForm->save()) {
                $this->redirect($answer->getUrl());
            }
            else
                var_dump($answer);
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
