<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = '登录';
?>
<div class="site-login">
    <h2><?= hencode($this->title) ?></h2>

    <p>请输入您的账号和密码</p>

    <div class="row">
        <div class="col-lg-5">
        <?php $form = ActiveForm::begin(['id' => 'form-login']); ?>
            <?= $form->field($model, 'username') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <div class="form-group">
                <?= Html::activeCheckbox($model, 'rememberAccount', [
                    'label'=>$model->getAttributeLabel('rememberAccount'),
                    'labelOptions'=>['class'=>'checkbox-inline']
                ]) ?>
                <?= Html::activeCheckbox($model, 'rememberMe', [
                    'label'=>$model->getAttributeLabel('rememberMe'),
                    'labelOptions'=>['class'=>'checkbox-inline']
                ]) ?>
                <label class="checkbox-inline">
                    <?= a('忘记密码？', ['site/request-password-reset']) ?>
                </label>
            </div>
            <div class="form-group">
                <?= Html::submitButton('登&nbsp;录', ['class' => 'btn btn-primary btn-submit', 'name' => 'login-button']) ?>
            </div>
        <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
