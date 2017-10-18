<?php

namespace app\components\file;

use Imagine\Image\Box;

class FileHelper
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
     * Возвращает название из пути
     * @param $dir
     * @return bool|string
     */
    protected static function getNameFromDir($dir)
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
    public static function removeDir($dir)
    {
        if ($files = glob($dir."/*")) {
            foreach($files as $file) {
                if (strripos($dir, 'uploads/') !== false) {
                    is_dir($file) ? self::removeDir($file) : unlink($file);
                }
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
     * Перемещает файл в директорию
     * @param $fromUrl
     * @param $toDir
     * @return bool|string
     */
    public static function moveFileToDir($fromUrl, $toDir) {
        if ($fromUrl && file_exists($fromUrl)) {
            $newUrl = $toDir . '/' . self::getNameFromDir($fromUrl);
            if (file_exists($newUrl)) {
                $newUrl = self::addPrefix($newUrl,'9');
            }
            if (rename($fromUrl, $newUrl)) {
                return $newUrl;
            }
        }
        return false;
    }


}