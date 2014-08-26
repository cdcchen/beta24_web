<?php
namespace frontend\controllers;

use common\models\QuestionComment;
use Yii;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\User;
use common\models\Question;
use common\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
//        echo Yii::getAlias('@app');exit;

        return $this->render('index');
    }

    public function actionTest()
    {
        $ac = new QuestionComment();
        $q = Question::find()->with('answers')->one();
//        var_dump($q);
//        $a = $q->getAnswers()->all();
        $a = $q->getAnswers()->all();
        var_dump($a);
//        exit;


//        user()->can('admin');

//        $questions1 = Question::find()->joinWith('user')->all();
//        var_dump($questions1);
//        $questions2 = Question::find()->joinWith('user')->all();
//        var_dump($questions2);

//        exit;

//        $questions = Question::find()->with([
//            'user' => function(ActiveQuery $query){
//                    $query->with('questions');
//                }
//        ])->all();
//        var_dump($questions[0]->user->questions[0] === $questions[0]);
//        $question = Question::findOne(1);
//        var_dump($question->user->questions[1] === $question);
//        exit;

//        $user = User::findOne(1);
//        var_dump($question->user === $user);
//        exit;

//        $questions = $user->getQuestions()->status([Question::STATUS_DONE, Question::STATUS_ACTIVE])->all();
//        var_dump($questions);
//        exit;

        return $this->render('test');
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

}
