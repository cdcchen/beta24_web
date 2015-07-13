<?php

namespace common\assets;

use yii\web\AssetBundle;

class ReactAsset extends AssetBundle
{
    public $basePath = '@staticRoot';
    public $baseUrl = '@static';

    public $css = [
    ];

    public $js = [
        'bower/react/JSXTransformer.js',
        'bower/react/react.min.js',
        'bower/react/react-with-addons.min.js',
    ];
}