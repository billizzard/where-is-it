<?php

namespace app\components\file;

use app\constants\ImageConstants;

class ImageTempHandler extends FileHandler
{
    /**
     * Возвращает актуальную директорию для временных файлов и удаляет старые
     * @return string
     */
    public static function getTempDir()
    {
        self::removeTempDir();
        return self::getCurrPathTempFolder();
    }

    /**
     * Удаляет временные папки, срок хранения которых истек
     */
    private static function removeTempDir()
    {
        $current = (int)self::getCurrNameTempFolder();
        $folders = self::getFoldersList(ImageConstants::FOLDERS['TEMP']);

        foreach ($folders as $folder) {
            $old = (int)self::getNameFromDir($folder);
            if ($old !== $current && $old !== $current - 1) {

                if (!($current === 0 && $old === 23)) {
                    self::removeDir($folder);
                }
            }
        }
    }

    /**
     * Возвращает актуальную дитекторию для хранения временных файлов
     * так как они затираются в зависимости от времени
     * @return string
     */
    private static function getCurrPathTempFolder()
    {
        $current = ImageConstants::FOLDERS['TEMP'] . self::getCurrNameTempFolder();
        if (!file_exists($current)) {
            mkdir($current, 0777);
        }
        return $current;
    }

    /**
     * Возвращает актуальное название директории для хранения временных файлов
     * @return false|string
     */
    private static function getCurrNameTempFolder()
    {
        return date('H');
    }

    protected static function getSizes()
    {
        return array_values(ImageConstants::IMAGE_SIZE);
    }

    public static function createThumbs($url)
    {
        return parent::createThumbs($url); // TODO: Change the autogenerated stub
    }
}