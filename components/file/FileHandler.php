<?php

namespace app\components\file;

use Imagine\Image\Box;

class FileHandler extends AFileHandler
{
    /**
     * Возвращает массив папок, содержащихся в директории
     * @param $folder
     * @return array
     */
    protected static function getFoldersList($folder)
    {
        return glob( $folder . '*', GLOB_ONLYDIR );
    }

    /**
     * Возвращает название последней папки в пути
     * @param $dir
     * @return bool|string
     */
    protected static function getFolderNameFromDir($dir)
    {
        $pos = strripos($dir, '/');
        if ($pos !== false) {
            $dir = substr($dir, $pos + 1);
        }
        return $dir;
    }

    /**
     * Удаляет директорию и все ее содержимое
     * @param $dir
     */
    protected static function removeDir($dir)
    {
        if ($files = glob($dir."/*")) {
            foreach($files as $file) {
                is_dir($file) ? self::removeDir($file) : unlink($file);
            }
        }
        rmdir($dir);
    }

    /**
     * Добавляет к файлу префикс
     * @param $url
     * @param $prefix
     * @return string
     */
    protected static function addPrefix($url, $prefix) {
        $newUrl = '';
        $pos = strripos($url, '/');
        if ($pos !== false) {
            $newUrl = substr($url, 0, $pos + 1) . $prefix . substr($url, $pos + 1);
        }
        return $newUrl;
    }

    /**
     * Создает уменьшенные копии изображений
     * @param $url
     */
    protected static function createThumbs($url) {
        if ($sizes = static::getSizes()) {
            foreach ($sizes as $size) {
                $urlThumb = self::addPrefix($url, $size[0]);
                \yii\imagine\Image::getImagine()->open($url)->thumbnail(new Box($size[1], $size[2]))->save($urlThumb, ['jpeg_quality' => 100]);
            }
        }
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
        $result = ['original' => $url];
        if ($sizes = static::getSizes()) {
            foreach ($sizes as $size) {
                $result[$size[0]] = self::addPrefix($url, $size[0]);
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