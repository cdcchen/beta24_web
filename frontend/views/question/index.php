<?php
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $pages yii\widgets\LinkPager */
/* @var $questions common\models\Question[] */
?>

<h1>question/index</h1>

<div class="beta-content fleft">

<?php echo $this->render('_list', ['models' => $questions]);?>

<?php
echo LinkPager::widget([
    'pagination' => $pages,
]);
?>

</div>


<div class="beta-sidebar fright">
    sidebar
</div>