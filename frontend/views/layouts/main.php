<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\AppAsset;
use frontend\widgets\UserNavBar;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= hencode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody();?>

    <div id="beta-topbar" class="beta-wrapper">
        <div class="container">
            <div class="site-links">
                <a href="#">新闻</a>
                <a href="#">标签</a>
            </div>
            <div class="user-links">
                <?= UserNavBar::widget() ?>
            </div>
            <div class="search">
                <form action="#">
                    <input type="text" name="kw" />
                </form>
            </div>
        </div>
    </div>

    <div id="beta-header" class="beta-wrapper">
        <div class="container clearfix">
            <a class="logo text-hide" href="/"><?= app()->name ?></a>
            <ul class="main-nav pull-right">
                <li class="<?= $this->params['channel'] == CHANNEL_QUESTION ? 'active' : '' ?>">
                    <a href="<?= Url::toRoute('question/index') ?>">所有问题</a>
                </li>
                <li class="<?= $this->params['channel'] == CHANNEL_TAG ? 'active' : '' ?>">
                    <a href="<?= Url::toRoute('tag/index') ?>">标签</a>
                </li>
                <li class="<?= $this->params['channel'] == CHANNEL_USER ? 'active' : '' ?>">
                    <a href="<?= Url::toRoute('user/index') ?>">用户</a>
                </li>
                <li class="<?= $this->params['channel'] == CHANNEL_BADGE ? 'active' : '' ?>">
                    <a href="<?= Url::toRoute('badge/index') ?>">徽章</a>
                </li>
                <li class="<?= $this->params['channel'] == CHANNEL_UNANSWERED ? 'active' : '' ?>">
                    <a href="<?= Url::toRoute('unanswered/index') ?>">未回答</a>
                </li>
                <li class="delimiter"></li>
                <li class="<?= $this->params['channel'] == 'ask_question' ? 'active' : '' ?>">
                    <a href="<?= Url::toRoute('question/ask') ?>">提问问题</a>
                </li>
            </ul>
        </div>
    </div>

    <div id="beta-content" class="beta-wrapper clearfix">
        <div class="container">
            <?= $content ?>
        </div>
    </div>

    <div id="beta-footer" class="beta-wrapper clearfix">
        <div class="container">
            footer
        </div>
    </div>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
