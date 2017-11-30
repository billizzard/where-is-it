<?php

namespace app\components\file;


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
        $info = pathinfo($dir);
        return $info['basename'];
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
        if (is_dir($dir)) {
            rmdir($dir);
        }
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
     * Перемещает или копирует файл в директорию
     * @param $fromUrl
     * @param $toDir
     * @param bool $copy
     * @return bool|string
     */
    public static function moveFileToDir($fromUrl, $toDir, $copy = false) {
        if (substr($fromUrl, 0, 1) === '/') {
            $fromUrl = substr($fromUrl, 1);
        }
        if ($fromUrl && file_exists($fromUrl) && $toDir && file_exists($toDir)) {
            $info = pathinfo($fromUrl);
            $newUrl = $toDir . '/' . uniqid() . '.' . $info['extension'];

            if (file_exists($newUrl)) {
                $newUrl = self::addPrefix($newUrl,'9');
            }
            if ($copy) {
                if (copy($fromUrl, $newUrl)) {
                    return $newUrl;
                }
            } else {
                if (rename($fromUrl, $newUrl)) {
                    return $newUrl;
                }
            }
        }
        return false;
    }


}