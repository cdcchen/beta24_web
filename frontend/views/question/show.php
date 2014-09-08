<?php
/* @var $this yii\web\View */
/* @var $question common\models\Question */
/* @var $comments array|common\models\QuestionComment[] */
/* @var $answers array|common\models\Answer[] */
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
    <div class="cdc-block question-top">
        <img src="http://static.adzerk.net/Advertisers/46a9844d6e504212a85bc72ddd7dd829.png" />
    </div>
    <div class="question clearfix" id="question">
        <div class="vote-cell">
            <a class="bg-icons vote-up-off" href="#">支持</a>
            <span class="vote-count"><?= $question->vote_up ?></span>
            <a class="bg-icons vote-down-off" href="#">反对</a>
            <a class="bg-icons star-off" href="#">收藏</a>
        </div>
        <div class="post-cell">
            <div class="post-content"><?= formatter()->asParagraphs($question->content) ?></div>
            <div class="post-tags">
                <?= $question->getTagsLinks() ?>
            </div>
            <div class="share-box">
                <a href="#">share</a>
            </div>
            <div class="post-userinfo">
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
</div>

<div class="clear"></div>