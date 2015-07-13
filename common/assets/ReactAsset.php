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
        'vendor/react/JSXTransformer.js',
        'vendor/react/react.min.js',
        'vendor/react/react-with-addons.min.js',
    ];
}