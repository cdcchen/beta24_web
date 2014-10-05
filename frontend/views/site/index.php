<?php

/* @var $this yii\web\View */
/* @var $questions common\models\Question[] */
/* @var $pages yii\widgets\LinkPager */
/* @var $models common\models\Question[] */
/* @var $tab string */

$this->title = app()->name;

?>

<div class="beta-sidebar">
    sidebar
</div>

<div class="beta-mainbar">
    <?php echo $this->render('_index_tab', ['questions' => $questions, 'tab'=>$tab]);?>

    <div class="questions-mini clearfix">
        <?php foreach ($questions as $q):?>
            <div class="question-item clearfix">
                <div class="question-mini-stats">
                    <div class="votes" title="<?= $q->answer_count ?> 个好评">
                        <strong><?= $q->vote_up ?></strong>votes
                    </div>
                    <div class="answers <?= ($q->answer_count > 0 ? 'answered' : 'unanswered') ?>" title="<?= $q->answer_count ?> 个回答">
                        <strong><?= $q->answer_count ?></strong>answers
                    </div>
                    <div class="views <?= $q->getViewsClassName(false) ?>" title="<?= $q->answer_count ?> 次浏览">
                        <strong><?= $q->getViews() ?></strong>views
                    </div>
                </div>
                <div class="question-summary narrow">
                    <h3><?= a(hencode($q->title), $q->getUrl(), ['title'=>hencode($q->getSummary())]) ?></h3>
                    <div class="post-tags">
                        <?= $q->getTagsLinks() ?>
                    </div>
                    <div class="post-started">
                        <a class="started-link" target="_blank" href="<?= $q->getUrl() ?>" title="<?= $q->getCreatedAt() ?>">asked <?= $q->getRelativeCreatedAt() ?></a>
                        <?= a($q->user->getDisplayName(), $q->user->getHomeUrl(), ['target'=>'_blank']) ?>
                        <span title="声望值"><?= $q->user->profile->data_reputation ?></span>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>
        <?php endforeach;?>
    </div>
    <br class="clear" />
    <h2 class="bottom-notice">
        Looking for more? Browse the <a href="/questions">complete list of questions</a>, or <a href="/tags">popular tags</a>. Help us answer <a href="/unanswered">unanswered questions</a>.
    </h2>
</div>

<div class="clear"></div>