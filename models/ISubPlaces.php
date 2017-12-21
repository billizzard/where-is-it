<?php

namespace app\models;

use app\components\file\FileHelper;
use app\components\file\ImagePlaceHandler;
use app\components\SiteException;
use app\constants\AppConstants;
use app\constants\ImageConstants;
use yii\behaviors\TimestampBehavior;



interface ISubPlaces
{

    public static function isCanAddMore($place_id);

}
