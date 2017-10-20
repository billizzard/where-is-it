<?php

namespace app\constants;


class ImageConstants
{
    const TYPE = [
        'MAIN' => 0,
        'GALLERY' => 1,
    ];

    const IMAGE_SIZE = [
        'MAP'=> ['map_',240, 180],
        'PREVIEW_MAIN' => ['preview_main_', 60, 45]
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