<?php
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $pages yii\widgets\LinkPager */
/* @var $pages common\base\Pagination
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

    <div class="pages clearfix">
        <ul class="pagination per-page pull-right">
            <li><a href="<?= $pages->createPageSizeUrl(1) ?>">20</a></li>
            <li><a href="<?= $pages->createPageSizeUrl(2) ?>">35</a></li>
            <li><a href="<?= $pages->createPageSizeUrl(3) ?>">50</a></li>
        </ul>
        <div class="per-page-label pull-right">每页：</div>
        <?php echo LinkPager::widget(['pagination' => $pages, 'class'=>'x']);?>
    </div>
</div>

<div class="clear"></div>
