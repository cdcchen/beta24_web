<?php
/* @var $this yii\web\View */
/* @var $question common\models\Question */
/* @var $comments array|common\models\QuestionComment[] */
/* @var $answers array|common\models\Answer[] */
?>
    <br />
<div class="btn-group">
    <button type="button" class="btn btn-default">Left</button>
    <button type="button" class="btn btn-default">Middle</button>
    <button type="button" class="btn btn-default">Right</button>
</div>
<br /><br /><br />
<div class="dropdown">
    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
        Dropdown
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Action</a></li>
        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another action</a></li>
        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Something else here</a></li>
        <li role="presentation" class="divider"></li>
        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Separated link</a></li>
    </ul>
</div>

<p>
    <a class="btn btn-default icon-test">
        <span class="glyphicon glyphicon-star"></span>&nbsp;我操啊
    </a>
</p>

<div class="test">class test</div>


<h1>question/show</h1>

<div class="alert alert-warning alert-dismissible">
    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
    <strong>Warning!</strong> Better check yourself, you're not looking too good.
</div>

<div class="alert alert-success alert-dismissible">
    <button type="button" class="close"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
    <h4>title</h4>
    <p>sadfadfasdf<a class="alert-link" href="#">link</a></p>
</div>
    <button class="btn btn-default btn-lg">测试按钮</button>

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