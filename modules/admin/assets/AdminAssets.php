<?php
namespace app\modules\admin\assets;

use yii\web\AssetBundle;
class AdminAssets extends AssetBundle
{

    public $js = [
        'js/js.js',
        'js/datetimepicker.js',
        'js/adminPlaceMap.js',
        'js/admin.js',
        'js/avatars.js'
        // more plugin Js here
    ];
    public $css = [
        '/css/site.css',
        '/css/admin/admin.css',
        '/css/datepicker.css'

        // more plugin CSS here
    ];
    public $depends = [
        //'dmstr\web\AdminLteAsset',
    ];
}