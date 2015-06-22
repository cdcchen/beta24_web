<?php
/**
 * Created by PhpStorm.
 * User: chendong
 * Date: 14-9-19
 * Time: 下午1:03
 */


namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class PageDownAsset extends AssetBundle
{
    public $basePath = '@staticRoot';
    public $baseUrl = '@static';

    public $css = [
        'vendor/pagedown/markdown_editor.css',
    ];

    public $js = [
        'vendor/pagedown/Markdown.Converter.js',
        'vendor/pagedown/Markdown.Sanitizer.js',
        'vendor/pagedown/Markdown.Editor.js',
    ];

    public $jsOptions = [
        'position' => View::POS_HEAD,
    ];

    public $depends = [
    ];
}
