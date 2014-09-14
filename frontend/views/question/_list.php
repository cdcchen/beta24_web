<?php
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $pages yii\widgets\LinkPager */
/* @var $models common\models\Question[] */
?>

<div class="questions">
<?php foreach ($models as $q):?>
    <div class="question-item clearfix">
        <div class="question-stats">
            <div class="post-stats">
                <div class="votes">
                    <strong><?= $q->vote_up ?></strong>votes
                </div>
                <div class="answers <?= $q->answer_count > 0 ? 'answered' : 'unanswered' ?>">
                    <strong><?= $q->answer_count ?></strong>answers
                </div>
            </div>
            <div class="post-views <?= $q->getViewsClassName(false) ?>"><?= $q->getViews() ?>&nbsp;views</div>
        </div>
        <div class="question-summary">
            <h3><?= a(hencode($q->title), $q->getUrl()) ?></h3>
            <p class="post-excerpt"><?= hencode($q->getSummary()) ?></p>
            <div class="post-tags">
                <?= $q->getTagsLinks() ?>
            </div>
            <div class="post-userinfo">
                <div class="asked-time">asked：<?= $q->createdAt ?></div>
                <a class="gravatar gravatar32 pull-left" href="<?= $q->user->getHomeUrl() ?>" target="_blank">
                    <?= $q->user->profile->getGavatarImg(32) ?>
                </a>
                <div class="detail">
                    <?= a($q->user->getDisplayName(), $q->user->getHomeUrl(), ['target'=>'_blank']) ?>
                    <br />
                    <span title="声望值"><?= (int)$q->user->profile->data_reputation ?></span>
                    <span title="徽章数">20</span>
                </div>
            </div>
        </div>
    </div>
<?php endforeach;?>
</div>