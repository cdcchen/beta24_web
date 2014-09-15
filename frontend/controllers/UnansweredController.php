<?php

namespace frontend\controllers;

use common\base\Pagination;
use frontend\base\Controller;
use common\models\Question;
use common\models\QuestionQuery;

class UnansweredController extends Controller
{
    public function init()
    {
        parent::init();

        $this->channel = CHANNEL_UNANSWERED;
    }

    public function actionIndex($sort = '')
    {
        $query = static::buildQuestionQuery($sort);
        $pages = new Pagination(['totalCount' => $query->count()]);
        $pages->defaultPageSize = 15;
        $questions = static::fetchQuestions($query, $pages);

        return $this->render('/question/index', [
            'tab_view' => '_unanswered_tab',
            'sort' => $sort,
            'pages' => $pages,
            'questions' => $questions,
        ]);
    }

    /***************************** fetch question list *****************************/

    private static function buildQuestionQuery($sort)
    {
        $query = Question::find()->active();
        switch ($sort)
        {
            case TAB_UNANSWERED_SORT_NEWEST:
                $query->unanswered()->orderBy(['created_at' => SORT_DESC]);
                break;
            case TAB_UNANSWERED_SORT_BOUNTY:
                $query->unanswered()->hasBounty()->orderBy(['open_bounty_end_time' => SORT_ASC]);
                break;
            case TAB_UNANSWERED_SORT_MY_TAGS:
                //@todo 这个开始不添加，待总是和用户数量多了以后才会有意义。
                $query->unanswered()->orderBy(['vote_up' => SORT_DESC, 'created_at' => SORT_DESC]);
                break;
            case TAB_UNANSWERED_SORT_NO_UPVOTED: // 暂时跟 no answers 一样
                $query->unanswered()->orderBy(['vote_up' => SORT_DESC, 'created_at' => SORT_DESC]);
                break;
            case TAB_UNANSWERED_SORT_NO_ANSWERS:
            default:
                $query->unanswered()->orderBy(['vote_up' => SORT_DESC, 'created_at' => SORT_DESC]);
                break;
        }

        return $query;
    }

    private static function fetchQuestions(QuestionQuery $query, Pagination $pages)
    {

        return $query->limit($pages->limit)->offset($pages->offset)->all();
    }

}
