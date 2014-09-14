<?php
use yii\helpers\Url;

/* @var $sort string */
/* @var $question \common\models\Question */
?>
<a name="answers"></a>
<!-- Nav tabs -->
<ul class="nav nav-tabs nav-right nav-small" id="sub-header">
    <li class="title"><h1><?= $question->answer_count ?>&nbsp;个回答</h1></li>
    <li class="<?= ($sort == ANSWER_SORT_VOTES) ? 'active' : '' ?>">
        <a href="<?= $question->getSortComments(ANSWER_SORT_VOTES) ?>">投票最多</a>
    </li>
    <li class="<?= ($sort == ANSWER_SORT_OLDEST) ? 'active' : '' ?>">
        <a href="<?= $question->getSortComments(ANSWER_SORT_OLDEST) ?>">回答时间</a>
    </li>
    <li class="<?= (empty($sort) || $sort == ANSWER_SORT_ACTIVE) ? 'active' : '' ?>">
        <a href="<?= $question->getSortComments(ANSWER_SORT_ACTIVE) ?>">最近更新</a>
    </li>
</ul>