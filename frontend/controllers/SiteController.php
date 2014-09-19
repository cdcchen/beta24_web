<?php
namespace frontend\controllers;

use frontend\base\Controller;
use common\models\QuestionQuery;
use Yii;
use common\models\Question;
use yii\helpers\Markdown;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public function actionIndex($tab = '')
    {
        $query = static::buildQuery($tab);
        $questions = static::fetchQuestions($query, 90);

        return $this->render('index', [
            'tab' => $tab,
            'questions' => $questions,
        ]);
    }

    public function actionError()
    {
        $exception = \Yii::$app->errorHandler->exception;
        if (YII_DEBUG && $exception !== null) {
            return $this->render('/system/error', ['exception' => $exception]);
        }

        if ($exception !== null) {
            return $this->render('/system/exception', ['exception' => $exception]);
        }

    }

    public function actionTest()
    {
        var_dump($_POST);
        return $this->render('test');
    }


    /***************************** fetch question list *****************************/

    private static function buildQuery($tab)
    {
        $query = Question::find()->active();
        if ($tab == TAB_SITE_FEATURED)
        {
            $query->andWhere('open_bounty > 0 and open_bounty_end_time > :current_time', [':current_time' => REQUEST_TIME]);
            $query->orderBy(['open_bounty_end_time' => SORT_ASC]);
        }
        elseif (in_array($tab, [TAB_SITE_HOT, TAB_SITE_WEEK, TAB_SITE_MONTH])) {
            if ($tab == TAB_SITE_HOT)
                $days = 3;
            elseif ($tab == TAB_SITE_WEEK)
                $days = 7;
            elseif ($tab == TAB_SITE_MONTH)
                $days = 30;
            else
                $days = 1;

            $query->andWhere('created_at > :timestamp', [':timestamp' => $days * ONE_DAY_SECONDS]);
            $query->orderBy(['vote_up' => SORT_DESC, 'created_at' => SORT_DESC]);
        }
        else { // include TAB_SITE_INTERESTING
            $query->orderBy(['updated_at' => SORT_DESC, 'created_at' => SORT_DESC]);
        }

        return $query;
    }

    private static function fetchQuestions(QuestionQuery $query, $count = 50)
    {

        return $query->limit($count)->all();
    }

}
