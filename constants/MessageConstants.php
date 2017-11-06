<?php

namespace app\constants;


class MessageConstants
{
    const TYPE = [
        'COMPLAIN' => 1,
        'REVIEW' => 2,
    ];

    public static function getTypeMap()
    {
        return [
            self::TYPE['COMPLAIN'] => 'Жалоба',
            self::TYPE['REVIEW'] => 'Отзыв',
        ];
    }

}