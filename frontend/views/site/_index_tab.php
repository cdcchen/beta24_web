<?php
use yii\helpers\Url;

/* @var $tab string */
?>

<!-- Nav tabs -->
<ul class="nav nav-tabs nav-right nav-small" id="sub-header">
    <li class="title"><h1>我的相关问题</h1></li>
    <li class="<?= ($tab == TAB_SITE_MONTH) ? 'active' : '' ?>">
        <a href="<?= Url::toRoute(['site/index', 'tab'=>TAB_SITE_MONTH]) ?>">一月内热门</a>
    </li>
    <li class="<?= ($tab == TAB_SITE_WEEK) ? 'active' : '' ?>">
        <a href="<?= Url::toRoute(['site/index', 'tab'=>TAB_SITE_WEEK]) ?>">一周内热门</a>
    </li>
    <li class="<?= ($tab == TAB_SITE_HOT) ? 'active' : '' ?>">
        <a href="<?= Url::toRoute(['site/index', 'tab'=>TAB_SITE_HOT]) ?>">最近热门</a>
    </li>
    <li class="<?= ($tab == TAB_SITE_FEATURED) ? 'active' : '' ?>">
        <a href="<?= Url::toRoute(['site/index', 'tab'=>TAB_SITE_FEATURED]) ?>">金币悬赏</a>
    </li>
    <li class="<?= (empty($tab) || $tab == TAB_SITE_INTERESTING) ? 'active' : '' ?>">
        <a href="<?= Url::toRoute(['site/index', 'tab'=>TAB_SITE_INTERESTING]) ?>">我感兴趣的</a>
    </li>
</ul>