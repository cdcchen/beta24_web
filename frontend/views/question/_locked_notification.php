<?php

/* @var $this yii\web\View */
/* @var $question common\models\Question */
?>

<div class="question-status locked-notification clearfix">
    <h2>
        <b>Locked</b>&nbsp;by&nbsp;
        <a href="<?= $question->lockedUser->getHomeUrl() ?>"><?= $question->lockedUser->getDisplayName() ?></a>
        <span class="mod-flair" title="moderator">♦</span>
        <span dir="ltr" class="locked_at"><?= $question->getLockedAt() ?></span>
    </h2>
    <p>This post has been locked due to the high amount of off-topic comments generated. For extended discussions, please use <a href="http://chat.stackoverflow.com">chat</a>.</p>
</div>