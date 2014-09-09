<?php
use yii\helpers\Url;

?>

<!-- Nav tabs -->
<ul class="nav nav-tabs nav-right nav-small" id="sub-header">
    <li class="title"><h1><?= $answer_count ?>&nbsp;个回答</h1></li>
    <li class="<?= ($sort == QUESTION_SORT_VOTES) ? 'active' : '' ?>">
        <a href="<?= Url::toRoute(['question/index', 'sort'=>QUESTION_SORT_VOTES]) ?>">投票最多</a>
    </li>
    <li class="<?= ($sort == QUESTION_SORT_FREQUENT) ? 'active' : '' ?>">
        <a href="<?= Url::toRoute(['question/index', 'sort'=>QUESTION_SORT_FREQUENT]) ?>">回答时间</a>
    </li>
    <li class="<?= (empty($sort) || $sort == QUESTION_SORT_ACTIVE) ? 'active' : '' ?>">
        <a href="<?= Url::toRoute(['question/index', 'sort'=>QUESTION_SORT_ACTIVE]) ?>">最近更新</a>
    </li>
</ul>