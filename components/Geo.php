<?php

namespace app\components;


class Geo
{
    const SITE = "http://api.sypexgeo.net/eC9rz/json/";
    const TIME = 60 * 60 * 24 * 300;
    const SITE_YANDEX = "https://geocode-maps.yandex.ru/1.x/?format=json&geocode=";

    /**
     * Получает данные о положении по ip в формате json
     * @return mixed
     */
    private static function getJsonFromSite()
    {
        $content = '';
        $ip = $_SERVER['REMOTE_ADDR'];
        $fp = fopen(self::SITE . $ip, "r");
        while (!feof($fp)) {
            $content .= fread($fp, 1024);
        }
        fclose($fp);

        $json = json_decode($content);
        return $json;
    }

    private static function getCityNameFromSite()
    {
        $cityName = '';
        $json = self::getJsonFromSite();

        if ($json && $json->city && $json->city->name_ru) {
            $cityName = $json->city->name_ru;
        }

        return $cityName;
    }

    /**
     * Получает координаты с сайта
     * @return array
     */
    private static function getLatLonFromSite()
    {
        $result = [];
        $json = self::getJsonFromSite();
        if ($json && $json->city && $json->city->name_ru) {
            $result[] = $json->city->lat;
            $result[] = $json->city->lon;
        }

        return $result;
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

    /**
     * Устанавливает координаты пользователя в куки
     * @param $coords
     */
    public static function setUserLatLon($coords)
    {
        setcookie("lat", $coords[0], time() + self::TIME);
        setcookie("lon", $coords[1], time() + self::TIME);
    }

    /**
     * Возвращает координаты по умолчанию, Минск
     * @return array
     */
    private static function getDefaultUserLatLon()
    {
        return [53.904098, 27.556899];
    }

    /**
     * Получает координаты пользователя, определенная по ip
     * @return array
     */
    public static function getUserLatLon()
    {
        $coords = self::getLatLonFromSite();
        if (!$coords) {
            $coords = self::getDefaultUserLatLon();
        }
        return $coords;
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