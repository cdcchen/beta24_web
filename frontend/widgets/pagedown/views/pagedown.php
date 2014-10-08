<?php

/* @var $this yii\web\View */
/* @var $model frontend\models\QuestionForm */
?>

<div class="wmd-container">
    <div id="wmd-button-bar" class="wmd-button-bar"></div>

    <?= $textarea ?>

    <div class="bg-icons grippie" id="grippie"></div>

    <?= $errorMessage ?>
</div>
<div id="wmd-preview" class="wmd-panel wmd-preview post-content"></div>

<script type="text/javascript">
(function(){
    var converter = Markdown.getSanitizingConverter();

    converter.hooks.chain("preBlockGamut", function (text, rbg) {
        return text.replace(/^ {0,3}""" *\n((?:.*?\n)+?) {0,3}""" *$/gm, function (whole, inner) {
            return "<blockquote>" + rbg(inner) + "</blockquote>\n";
        });
    });

    var editor = new Markdown.Editor(converter);
    editor.run();
})();

</script>