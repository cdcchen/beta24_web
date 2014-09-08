<?php
use yii\helpers\Url;

?>

<!-- Nav tabs -->
<ul class="nav nav-tabs nav-right nav-small" id="sub-header">
    <li class="title"><h1>所有问题</h1></li>
    <li class="<?= ($sort == QUESTION_SORT_UNANSWERED) ? 'active' : '' ?>">
        <a href="<?= Url::toRoute(['question/index', 'sort'=>QUESTION_SORT_UNANSWERED]) ?>">未回答的</a>
    </li>
    <li class="<?= ($sort == QUESTION_SORT_ACTIVE) ? 'active' : '' ?>">
        <a href="<?= Url::toRoute(['question/index', 'sort'=>QUESTION_SORT_ACTIVE]) ?>">最近更新</a>
    </li>
    <li class="<?= ($sort == QUESTION_SORT_FREQUENT) ? 'active' : '' ?>">
        <a href="<?= Url::toRoute(['question/index', 'sort'=>QUESTION_SORT_FREQUENT]) ?>">最热门</a>
    </li>
    <li class="<?= ($sort == QUESTION_SORT_VOTES) ? 'active' : '' ?>">
        <a href="<?= Url::toRoute(['question/index', 'sort'=>QUESTION_SORT_VOTES]) ?>">投票最多</a>
    </li>
    <li class="<?= ($sort == QUESTION_SORT_BOUNTY) ? 'active' : '' ?>">
        <a href="<?= Url::toRoute(['question/index', 'sort'=>QUESTION_SORT_BOUNTY]) ?>">金币悬赏</a>
    </li>
    <li class="<?= (empty($sort) || $sort == QUESTION_SORT_NEWEST) ? 'active' : '' ?>">
        <a href="<?= Url::toRoute(['question/index', 'sort'=>QUESTION_SORT_NEWEST]) ?>">刚刚提问</a>
    </li>
</ul>