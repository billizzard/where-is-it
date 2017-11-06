<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

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
        'css/bootstrap.min.css',
        'css/site.css',
        'css/left-menu.css',
        'css/popup.css',
        'css/place.css',
        'css/jquery.fancybox.min.css',
    ];
    public $js = [
        /*'js/jquery-3.2.1.min.js',*/
        'js/bootstrap.min.js',
        'js/add_functions.js',
        'js/fileUploader.js',
        'js/js.js',
        'js/yesNo.js',
        'js/placeMap.js',
        'js/jquery.fancybox.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
