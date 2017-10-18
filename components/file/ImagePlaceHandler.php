<?php

namespace app\components\file;

class ImagePlaceHandler extends FileHandler
{
    private static $folder = 'uploads/places/';

    /**
     * Создает директорию для хранения изображений места
     * @param $id
     * @return string
     */
    public static function createSaveDir($id) {
        for ($i = 1; $i < 500; $i++) {
            $folderFull = self::$folder . $i;
            if (!file_exists($folderFull)) {
                mkdir($folderFull, 0777);
            }
            $files = glob( $folderFull . '/*', GLOB_ONLYDIR );
            if (count($files) < 500) {
                $folderFull .= '/' . $id;
                if (!file_exists($folderFull)) {
                    mkdir($folderFull, 0777);
                }
                return $folderFull;
            }
        }
    }
}