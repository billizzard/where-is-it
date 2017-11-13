<?php

namespace app\constants;


class ImageConstants
{
    const TYPE = [
        'MAIN_PLACE' => 0,
        'GALLERY' => 1,
        'MAIN_DISCOUNT' => 3,
        'TEMP' => 4,
    ];

    const IMAGE_SIZE = [
        'MAP'=> ['map_',240, 180],
        'MAIN_DISCOUNT'=> ['discount_',240, 180],
        'PREVIEW_MAIN_PLACE' => ['add_', 60, 45]
    ];

    const SCENARIO = [
        'TEMP' => 'temp',
        'GALLERY' => 'gallery',
        'MAIN_DISCOUNT' => 'discount',
        'MAIN_PLACE' => 'discount',
    ];

    const FOLDERS = [
        'TEMP' => 'uploads/temp/',
    ];

    public static function getTypeMaps()
    {
        return [
            self::TYPE['MAIN_PLACE'] => 'Главное изображение',
            self::TYPE['GALLERY'] => 'Изображение галлереи',
            self::TYPE['TEMP'] => 'Временное изображение',
            self::TYPE['MAIN_DISCOUNT'] => 'Главное изображение',
        ];
    }

}