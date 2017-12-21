<?php

namespace app\components\file;

use app\constants\ImageConstants;

class ImageDiscountMain extends FileHandler
{
    protected static function getSizes()
    {
        return [
            ImageConstants::IMAGE_SIZE['MAIN_DISCOUNT']
        ];
    }

    public static function deleteFiles($url)
    {
        parent::deleteFiles($url); // TODO: Change the autogenerated stub
    }
}