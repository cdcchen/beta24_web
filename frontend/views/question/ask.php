<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\QuestionForm */
?>

<div class="beta-sidebar">
    sidebar
</div>

<div class="beta-mainbar">
    <?php $form = ActiveForm::begin();?>
        <?= $form->field($model, 'title')->textInput(['placeholder'=>'请尽量用一句话清楚描述您所遇到的问题']) ?>
        <?= $form->field($model, 'content')->textarea()->label('') ?>
        <?= $form->field($model, 'tags_text')->textInput(['placeholder'=>'至少1个标签，例如（php,mysql,json），最多5个']) ?>

        <div class="form-group">
            <div class="col-sm-offset-1 col-sm-11">
            <?= Html::submitButton('提交问题', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    <?php ActiveForm::end();?>
</div>
<div class="clear"></div>