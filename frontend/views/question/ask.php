<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\widgets\pagedown\PageDown;

/* @var $this yii\web\View */
/* @var $model frontend\models\QuestionForm */
?>

<div class="beta-sidebar">
    sidebar
</div>

<div class="beta-mainbar">
<?php $form = ActiveForm::begin();?>
    <?= $form->field($model, 'title')->textInput(['placeholder'=>'请尽量用一句话清楚描述您所遇到的问题', 'tabindex'=>100]) ?>
    <div class="form-group required <?= $model->hasErrors('content') ? 'has-error' : '' ?>">
    <?= PageDown::widget(['model'=>$model]) ?>
    </div>
    <?= $form->field($model, 'tags_text')->textInput(['placeholder'=>'至少1个标签，例如（php,mysql,json），最多5个', 'tabindex'=>102]) ?>

    <div class="form-group">
        <?= Html::submitButton('提交问题', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end();?>
</div>

<div class="clear"></div>