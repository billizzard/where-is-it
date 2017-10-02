<?php

namespace app\components;

use app\models\City;

class Geo
{
    const SITE = "http://api.sypexgeo.net/eC9rz/json/";
    const TIME = 60 * 60 * 24 * 300;
    const SITE_YANDEX = "https://geocode-maps.yandex.ru/1.x/?format=json&geocode=";

    private static function getCityNameFromSite()
    {
        $cityName = '';
        $content = '';
        $ip = $_SERVER['REMOTE_ADDR'];
        $fp = fopen(self::SITE . $ip, "r");
        while (!feof($fp)) {
            $content .= fread($fp, 1024);
        }
        fclose($fp);

        $json = json_decode($content);

        if ($json && $json->city && $json->city->name_ru) {
            $cityName = $json->city->name_ru;
        }

        return $cityName;
    }
    
    public static function getCoordsByCityName($name) 
    {
        $coords = [];
        $content = '';
        $fp = fopen(self::SITE_YANDEX + trim($name), "r");
        while (!feof($fp)) {
            $content .= fread($fp, 1024);
        }
        fclose($fp);

        $json = json_decode($content);

        if ($json &&
            $json->response &&
            $json->response->GeoObjectCollection->featureMember &&
            $json->response->GeoObjectCollection->featureMember[0]
        ) {
            $coordsStr = $json->response->GeoObjectCollection->featureMember[0]->GeoObject->Point->pos;
            $coords = explode(' ', $coordsStr);
        }

        return $coords;

    }

    private static function setUserCity($city_id, $city_name)
    {
        setcookie("city_id", $city_id, time() + self::TIME);
        setcookie("city_name", $city_name, time() + self::TIME);
    }

    public static function getUserCityId()
    {
        $city_id = '';

        if (isset($_COOKIE['city_id'])) {
            $city_id = (int)$_COOKIE['city_id'];
        } else {
            if ($city_name = self::getCityNameFromSite()) {
                /** @var City $city */
                $city = City::findByName($city_name)->one();
                if ($city) {
                    $city_id = $city->id;
                }
            }

            if (!$city_id) {
                $city = City::getDefaultCity();
                $city_id = $city->id;
            }
        }

        return $city_id;
    }

    public static function getAcceptedCity()
    {
        $city = null;
        if (isset($_COOKIE['city_id'])) {
            $city = City::findOne((int)$_COOKIE['city_id']);
        }
        return $city;
    }

    public static function getAcceptedCityId()
    {
        return isset($_COOKIE['city_id']) ? (int)$_COOKIE['city_id'] : '';
    }
}

?>