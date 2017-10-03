<?php
namespace app\modules\admin\assets;

use yii\web\AssetBundle;
class AdminAssets extends AssetBundle
{

    public $js = [
        'js/js.js',
        'js/adminPlaceMap.js'
        // more plugin Js here
    ];
    public $css = [
        '/css/site.css'

        // more plugin CSS here
    ];
    public $depends = [
        //'dmstr\web\AdminLteAsset',
    ];
}