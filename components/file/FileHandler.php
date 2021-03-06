<?php

namespace app\components\file;

use Imagine\Image\Box;

class FileHandler extends FileHelper
{
    /**
     * Создает уменьшенные копии изображений
     * @param $url
     * @return array
     */
    public static function createThumbs($url) {
        $res = ['original' => $url];
        if ($sizes = static::getSizes()) {
            foreach ($sizes as $size) {
                $urlThumb = self::addPrefix($url, $size[0]);
                $res[$size[0]] = $urlThumb;
                \yii\imagine\Image::getImagine()->open($url)->thumbnail(new Box($size[1], $size[2]))->save($urlThumb, ['jpeg_quality' => 100]);
            }
        }
        return $res;
    }

    /**
     * Удаляет изображения и все его нарезки
     * @param $url
     */
    protected static function deleteFiles($url)
    {
        if ($files = self::getAllImages($url)) {
            foreach($files as $file) {
                if (file_exists($file) && is_file($file)) {
                    unlink($file);
                }
            }
        }
    }

    /**
     * Возвращает все копии данного изображения
     * @param $url
     * @return array
     */
    public static function getAllImages($url)
    {
        $result = [];
        if ($url) {
            $result = ['original' => $url];
            if ($sizes = static::getSizes()) {
                foreach ($sizes as $size) {
                    $result[$size[0]] = self::addPrefix($url, $size[0]);
                }
            }
        }
        return $result;
    }

    /**
     * Возвращает все нужные размеры изображения
     * @return array
     */
    protected static function getSizes()
    {
       return [];
    }


}