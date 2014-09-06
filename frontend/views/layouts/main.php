<?php
use yii\helpers\Html;
use frontend\assets\AppAsset;

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
                <a href="#">登录</a>
                <a href="#">注册</a>
            </div>
            <div class="search">
                <form action="#">
                    <input type="text" name="kw" />
                </form>
            </div>
        </div>
    </div>

    <div id="beta-header" class="beta-wrapper">
        <div class="container">
            <a class="logo text-hide" href=""><?= app()->name ?></a>
            <ul class="ask-nav">
                <li><a href="#">提问问题</a></li>
            </ul>
            <ul class="main-nav">
                <li class="active"><a href="#">问题</a></li>
                <li><a href="#">标签</a></li>
                <li><a href="#">用户</a></li>
                <li><a href="#">徽章</a></li>
                <li><a href="#">未回答</a></li>
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
