<?php

namespace app\constants;


class ImageConstants
{
    const TYPE = [
        'MAIN' => 0,
        'GALLERY' => 1,
        'GALLERY_NEW_VARIANT' => 2,
        'MAIN_DISCOUNT' => 3,
        'TEMP' => 4,
    ];

    const IMAGE_SIZE = [
        'MAP'=> ['map_',240, 180],
        'DISCOUNT'=> ['discount_',240, 180],
        'PREVIEW_MAIN' => ['add_', 60, 45]
    ];

    const SCENARIO = [
        'TEMP' => 'temp'
    ];

    const FOLDERS = [
        'TEMP' => 'uploads/temp/',
    ];

    public static function getTypeMaps()
    {
        return [
            self::TYPE['MAIN'] => 'Главное изображение',
            self::TYPE['GALLERY'] => 'Изображение галлереи',
        ];
    }

}