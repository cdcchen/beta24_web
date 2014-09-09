<?php

/* @var $this yii\web\View */
/* @var $question common\models\Question */
?>

<div class="question-status bounty-notification clearfix">
    <h2>
        This question has an open <a href="/help/bounty">bounty</a> worth
        <span class="bounty-award">+<?= $question->open_bounty ?></span>
        reputation from <a href="<?= $question->user->getHomeUrl() ?>"><?= $question->user->getDisplayName() ?></a>
        ending <b title="started at <?= $question->getCreatedAt() ?> ending at <?= $question->getBountyEndingAt() ?>">in <?= $question->getBountyLeaveTime()?></b>.
    </h2>
    <p>This question has not received enough attention.</p>
    <p>Please answer as soon as you can. its urgent.</p>
</div>