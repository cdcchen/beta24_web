<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\QuestionForm */
?>

<div class="wmd-container">
    <div id="wmd-button-bar" class="wmd-button-bar"></div>

    <?= $textarea ?>

    <div class="bg-icons grippie" id="grippie"></div>

    <?= $errorMessage ?>
</div>
<div id="wmd-preview" class="wmd-panel wmd-preview"></div>

<script type="text/javascript">
(function(){
    var converter1 = Markdown.getSanitizingConverter();

    converter1.hooks.chain("preBlockGamut", function (text, rbg) {
        return text.replace(/^ {0,3}""" *\n((?:.*?\n)+?) {0,3}""" *$/gm, function (whole, inner) {
            return "<blockquote>" + rbg(inner) + "</blockquote>\n";
        });
    });

    var editor1 = new Markdown.Editor(converter1);

    editor1.run();
})();

</script>