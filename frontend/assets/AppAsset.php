<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
//        'css/stylus/betaboot.css',
        'css/site.css',
    ];
    public $js = [
        'http://static.waduanzi.com/libs/bootstrap/js/bootstrap.min.js',
        'js/site.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
