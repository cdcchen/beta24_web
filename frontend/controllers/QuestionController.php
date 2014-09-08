<?php

namespace frontend\controllers;

use common\base\Pagination;
use common\models\QuestionCommentQuery;
use common\models\Question;
use common\models\QuestionQuery;

class QuestionController extends \yii\web\Controller
{
    public function actionIndex($sort = null)
    {
        $query = static::buildQuery($sort);
        $pages = new Pagination(['totalCount' => $query->count()]);
        $pages->defaultPageSize = 15;
        $questions = static::fetchQuestions($query, $pages);

        return $this->render('index', [
            'sort' => $sort,
            'pages' => $pages,
            'questions' => $questions,
        ]);
    }

    public function actionAsk()
    {
        return $this->render('ask');
    }

    public function actionShow($id)
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
        $answers = $question->getAnswers()->limit($pages->limit)->offset($pages->offset)
            ->with(['user', 'comments'])->all();

        return $this->render('show', [
            'question' => $question,
            'answers' => $answers,
        ]);
    }


    /***************************** fetch question list *****************************/

    private static function buildQuery($sort)
    {
        $query = Question::find()->active();
        switch ($sort)
        {
            case QUESTION_SORT_ACTIVE:
                $query->orderBy(['updated_at' => SORT_DESC]);
                break;
            case QUESTION_SORT_BOUNTY:
                $query->andWhere('open_bounty > 0 and open_bounty_end_time > :current_time', [':current_time' => REQUEST_TIME]);
                $query->orderBy(['open_bounty_end_time' => SORT_ASC]);
                break;
            case QUESTION_SORT_UNANSWERED:
                $query->andWhere('answer_count = 0');
                $query->orderBy(['vote_up' => SORT_DESC, 'created_at' => SORT_DESC]);
                break;
            case QUESTION_SORT_VOTES:
                $query->orderBy(['vote_up' => SORT_DESC]);
                break;
            case QUESTION_SORT_FREQUENT:
                //@todo 这个是最经常被提到的问题，开始不显示，后续问题多了，再添加。
            case QUESTION_SORT_NEWEST:
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
