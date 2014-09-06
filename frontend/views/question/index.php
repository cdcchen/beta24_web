<?php
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $pages yii\widgets\LinkPager */
/* @var $questions common\models\Question[] */
?>

<div class="beta-sidebar">
    sidebar<br /><br /><br />
    sidebar<br /><br /><br />
    sidebar<br /><br /><br />
    sidebar<br /><br /><br />
    sidebar<br /><br /><br />
</div>

<div class="beta-mainbar">

<?php echo $this->render('/public/question_tab');?>
<?php echo $this->render('_list', ['models' => $questions]);?>

<?php echo LinkPager::widget(['pagination' => $pages]);
?>
</div>

<div class="clear"></div>
