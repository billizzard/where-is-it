<?php

namespace app\constants;


class AppConstants
{
    const COUNT_COPIES = 5;

    const STATUS = [
        'NO_MODERATE' => 0,
        'MODERATE' => 1,
    ];

    public static function getStatusMap()
    {
        return [
            self::STATUS['NO_MODERATE'] => 'Не проверено',
            self::STATUS['MODERATE'] => 'Проверено',
        ];
    }

}