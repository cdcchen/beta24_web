<?php

use yii\widgets\LinkPager;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\widgets\pagedown\PageDown;

/* @var $this yii\web\View */
/* @var $question common\models\Question */
/* @var $comments array|common\models\QuestionComment[] */
/* @var $answers array|common\models\Answer[] */
/* @var $answerForm frontend\models\AnswerForm */
/* @var $pages yii\data\Pagination */
/* @var $sort string */
?>

<div class="question-header">
    <h1><?= $question->title ?></h1>
</div>

<div class="beta-sidebar">
    sidebar<br /><br /><br />
    sidebar<br /><br /><br />
    sidebar<br /><br /><br />
    sidebar<br /><br /><br />
    sidebar<br /><br /><br />
</div>

<div class="beta-mainbar">
<!--    <div class="cdc-block question-top">-->
<!--        <img src="http://static.adzerk.net/Advertisers/46a9844d6e504212a85bc72ddd7dd829.png" />-->
<!--    </div>-->
    <div class="question clearfix" id="question">
        <div class="vote-cell">
            <a class="bg-icons vote-up-off" href="#">支持</a>
            <span class="vote-count"><?= $question->vote_up ?></span>
            <a class="bg-icons vote-down-off" href="#">反对</a>
            <a class="bg-icons star-off" href="#">收藏</a>
        </div>
        <div class="post-cell clearfix">
            <div class="post-content"><?= $question->getPurifyContent() ?></div>
            <div class="post-tags">
                <?= $question->getTagsLinks() ?>
            </div>
            <div class="share-box">
                <a href="#">分享</a>
            </div>
            <div class="post-userinfo owner">
                <div class="asked-time">asked：<?= $question->createdAt ?></div>
                <a class="gravatar gravatar32 pull-left" href="<?= $question->user->getHomeUrl() ?>" target="_blank">
                    <?= $question->user->profile->getGavatarImg(32) ?>
                </a>
                <div class="detail">
                    <a href="<?= $question->user->getHomeUrl() ?>" target="_blank">
                        <?=$question->user->getDisplayName() ?>
                    </a>
                    <br />
                    <span>10</span>
                    <span>20</span>
                </div>
            </div>
        </div>
    </div>

    <?php
        if ($question->locked_at)
            echo $this->render('_locked_notification', ['question'=>$question]);

        if ($question->open_bounty > 0 && $question->open_bounty_end_time > REQUEST_TIME)
            echo $this->render('_bounty_notification', ['question'=>$question]);
    ?>

    <?php if (count($question->comments) > 0):?>
    <ul class="comments clearfix" id="">
        <?php foreach ($question->comments as $c):?>
        <li>
            <?= hencode($c->content) ?>
            <a href="<?= $c->user->homeUrl ?>" class="user"><?= $c->user->displayName ?></a>
            <span class="datetime"><?= $c->getCreatedAt() ?></span>
        </li>
        <?php endforeach;?>
    </ul>
    <?php endif;?>
    <div class="comments-link clearfix">
        <a class="new-comment" href="#">添加评论</a>
    </div>

    <?php echo $this->render('/answer/_answer_tab', ['sort'=>$sort, 'question' => $question]);?>


    <div class="answers clearfix">
        <?php echo $this->render('/answer/_list', ['question' => $question,'answers' => $answers]);?>
        <div class="pages clearfix">
            <ul class="pagination per-page pull-right">
                <li class="<?= $pages->pageSize == 20 ? 'active' : '' ?>">
                    <a href="<?= $pages->createUrl($pages->page, 20) ?>">20</a>
                </li>
                <li class="<?= $pages->pageSize == 30 ? 'active' : '' ?>">
                    <a href="<?= $pages->createUrl($pages->page, 30) ?>">30</a>
                </li>
                <li class="<?= $pages->pageSize == 50 ? 'active' : '' ?>">
                    <a href="<?= $pages->createUrl($pages->page, 50) ?>">50</a>
                </li>
            </ul>
            <div class="per-page-label pull-right">每页：</div>
            <?php echo LinkPager::widget(['pagination' => $pages]);?>
        </div>
    </div>

    <!-- answer form -->
    <div class="answer-form">
    <?php $form = ActiveForm::begin(['action'=>['question/create-answer']]);?>
        <?= Html::activeHiddenInput($answerForm, 'question_id') ?>
        <div class="form-group required <?= $answerForm->hasErrors('content') ? 'has-error' : '' ?>">
            <?= PageDown::widget(['model'=>$answerForm]) ?>
        </div>
        <div class="form-group">
            <?= Html::submitButton('提交答案', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end();?>
    </div>

</div>

<div class="clear"></div>