<?php
use yii\helpers\Url;

/* @var $sort string */
?>

<!-- Nav tabs -->
<ul class="nav nav-tabs nav-right nav-small" id="sub-header">
    <li class="title"><h1>没有回答的问题</h1></li>
    <li class="<?= (empty($sort) || $sort == TAB_UNANSWERED_SORT_NO_ANSWERS) ? 'active' : '' ?>">
        <a href="<?= Url::toRoute(['unanswered/index', 'sort'=>TAB_UNANSWERED_SORT_NO_ANSWERS]) ?>">无任何回答的</a>
    </li>
    <li class="<?= ($sort == TAB_UNANSWERED_SORT_NO_UPVOTED) ? 'active' : '' ?>">
        <a href="<?= Url::toRoute(['unanswered/index', 'sort'=>TAB_UNANSWERED_SORT_NO_UPVOTED]) ?>">无有效回答的</a>
    </li>
    <li class="<?= ($sort == TAB_UNANSWERED_SORT_NEWEST) ? 'active' : '' ?>">
        <a href="<?= Url::toRoute(['unanswered/index', 'sort'=>TAB_UNANSWERED_SORT_NEWEST]) ?>">最新提问的</a>
    </li>
    <li class="<?= ($sort == TAB_UNANSWERED_SORT_MY_TAGS) ? 'active' : '' ?>">
        <a href="<?= Url::toRoute(['unanswered/index', 'sort'=>TAB_UNANSWERED_SORT_MY_TAGS]) ?>">我感兴趣的</a>
    </li>
    <li class="<?= ($sort == TAB_UNANSWERED_SORT_BOUNTY) ? 'active' : '' ?>">
        <a href="<?= Url::toRoute(['unanswered/index', 'sort'=>TAB_UNANSWERED_SORT_BOUNTY]) ?>">金币悬赏</a>
    </li>
</ul>