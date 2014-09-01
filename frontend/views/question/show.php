<?php
/* @var $this yii\web\View */
/* @var $question common\models\Question */
/* @var $comments array|common\models\QuestionComment[] */
/* @var $answers array|common\models\Answer[] */
?>
<h1>question/show</h1>


<h1>yyyyy<a href="#">sadfasfd</a>xxxxxxx</h1>


<?php

echo $question->title . ' - ' . $question->user->getDisplayName() . '<br />';

foreach ($question->comments as $qc)
    echo '<li>' . $qc->content . ' - ' . $qc->user->getDisplayName() . '</li>';

foreach ($answers as $a) {
    echo '<li>' . $a->content . ' - ' . $a->user->getDisplayName() . '</li>';

    foreach ($a->comments as $ac)
        echo '<li>---- ' . $ac->content . ' - ' . $ac->user->getDisplayName() . '</li>';
}