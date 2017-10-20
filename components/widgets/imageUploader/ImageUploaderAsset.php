<?php
namespace app\components\widgets\imageUploader;

use yii\web\AssetBundle;

class ImageUploaderAsset extends AssetBundle
{
    public $sourcePath = __DIR__ . '/assets';
    public $css = [
        'css/css.css',
    ];
    public $js = [
        'js/js.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}