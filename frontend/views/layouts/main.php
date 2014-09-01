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
        <div class="beta-container">
            top nav
        </div>
    </div>

    <div id="beta-header" class="beta-wrapper">
        <div class="beta-container">
            header
        </div>
    </div>

    <div id="beta-content" class="beta-wrapper">
        <div class="beta-container">
            <?= $content ?>
        </div>
    </div>

    <div id="beta-footer" class="beta-wrapper">
        <div class="beta-container">
            footer
        </div>
    </div>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
