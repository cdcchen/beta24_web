<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = '注册账号';
?>
<div class="site-signup">
    <h2><?= hencode($this->title) ?></h2>
    <p class="notice">请珍惜您的账号，一旦被禁用将永不解封。</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            <?= $form->field($model, 'email')->hint('仅作为登录账号使用，我们永远不会泄露您的邮箱。') ?>
            <?= $form->field($model, 'display_name')->hint('起个牛X的名字是很重要的，中文、英文、数字、空格或下划线。') ?>
            <?= $form->field($model, 'password')->passwordInput()->hint('密码最少需要6位') ?>
                <div class="form-group">
                    <?= Html::submitButton('注册', ['class' => 'btn btn-primary btn-submit', 'name' => 'signup-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="col-lg-5 col-lg-offset-2">

        </div>
    </div>
</div>
