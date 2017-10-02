<?php

namespace app\controllers;

use app\components\Geo;
use yii\web\Controller;

class BaseMapController extends Controller
{
    public $city_id;

    public function getUserCityId() {
        if (!$this->city_id) {
            $this->city_id = Geo::getUserCityId();
        }
        return $this->city_id;
    }
}
