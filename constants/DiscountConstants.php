<?php

namespace app\constants;


class DiscountConstants
{
    const TYPE = [
        'DISCOUNT' => 1,
        'ACTION' => 2,
    ];

    public static function getTypeMap()
    {
        return [
            self::TYPE['DISCOUNT'] => 'Скидка',
            self::TYPE['ACTION'] => 'Акция',
        ];
    }

}