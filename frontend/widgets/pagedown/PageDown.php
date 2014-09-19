<?php

namespace frontend\widgets\pagedown;

use frontend\assets\PageDownAsset;
use \yii\base\Widget;
use yii\helpers\Html;

class PageDown extends Widget
{
    /**
     * @var \common\models\Question|\common\models\Answer
     */
    public $model;
    public $attribute;

    public $text;
    public $textareaOptions;

    public function init()
    {

    }

    public function run()
    {
        $this->registerAssets();
        $this->registerAssets();

        return $this->render('pagedown', [
            'textarea' => $this->buildTextarea(),
            'errorMessage' => $this->buildErrorMessage(),
        ]);
    }

    private function registerAssets()
    {
        $view = $this->getView();
        PageDownAsset::register($view);
    }

    private function buildTextareaOptions()
    {
        $options = [
            'tabindex'=>102,
            'id'=>'wmd-input',
            'class'=>'wmd-input',
        ];

        return array_merge($options, (array)$this->textareaOptions);
    }

    private function buildTextarea()
    {
        $options = $this->buildTextareaOptions();
        $attribute = $this->attribute ? $this->attribute : 'content';

        if ($this->model)
            $textarea = Html::activeTextarea($this->model, $attribute, $options);
        else
            $textarea = Html::textarea($attribute, $this->text, $options);

        return $textarea;
    }

    private function buildErrorMessage()
    {
        $attribute = $this->attribute ? $this->attribute : 'content';

        if ($this->model && $this->model->hasErrors($attribute)) {
            $html = '<div class="help-block">';
            $html .= $this->model->getErrors($attribute)[0];
            $html .= '</div>';
        }
        else
            $html = '';

        return $html;
    }
}