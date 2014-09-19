<?php echo __FILE__;?>

<?php $form = \yii\widgets\ActiveForm::begin();?>
<label for="fangspotted">A e keni pare qenin tim Fang?</label>
Po <input id="fangspotted" name="fangspotted" type="radio" value="po"/>
Jo <input id="fangspotted" name="fangspotted" type="radio" value="jo"/><br/>

<input type="submit" value="submit" />
<?php \yii\widgets\ActiveForm::end();?>