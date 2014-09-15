<?php

use yii\widgets\LinkPager;

/**
 * @var $this yii\web\View
 * @var $pages yii\widgets\LinkPager
 * @var $pages common\base\Pagination
 * @var $questions common\models\Question[]
 * @var $sort string
 */
?>

<div class="beta-sidebar">
    sidebar<br /><br /><br />
    sidebar<br /><br /><br />
    sidebar<br /><br /><br />
    sidebar<br /><br /><br />
    sidebar<br /><br /><br />
</div>

<div class="beta-mainbar">
    <?php echo $this->render($tab_view, ['sort'=>$sort]);?>
    <?php echo $this->render('_list', ['models' => $questions]);?>

    <div class="pages clearfix">
        <ul class="pagination per-page pull-right">
            <li class="<?= $pages->pageSize == 15 ? 'active' : '' ?>">
                <a href="<?= $pages->createPageSizeUrl(15) ?>">15</a>
            </li>
            <li class="<?= $pages->pageSize == 30 ? 'active' : '' ?>">
                <a href="<?= $pages->createPageSizeUrl(30) ?>">30</a>
            </li>
            <li class="<?= $pages->pageSize == 50 ? 'active' : '' ?>">
                <a href="<?= $pages->createPageSizeUrl(50) ?>">50</a>
            </li>
        </ul>
        <div class="per-page-label pull-right">每页：</div>
        <?php echo LinkPager::widget(['pagination' => $pages]);?>
    </div>
</div>

<div class="clear"></div>
