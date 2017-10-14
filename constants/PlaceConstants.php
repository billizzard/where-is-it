<?php

namespace app\constants;


class PlaceConstants
{
    const TYPE = [
        'NO_CONFIRM' => 0,
        'CONFIRM' => 1,
    ];

    public static function getTypeMap()
    {
        return [
            self::TYPE['NO_CONFIRM'] => 'Не подтверждено',
            self::TYPE['CONFIRM'] => 'Подтверждено',
        ];
    }

}