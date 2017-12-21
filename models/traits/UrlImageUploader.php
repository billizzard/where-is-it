<?php

namespace app\models\traits;

use app\constants\ImageConstants;
use app\models\Image;

trait UrlImageUploader
{
    abstract public function getDir();

    /**
     * Сохраняет изображение по url и типу
     * @param $urls
     * @param $type
     * @return $this
     */
    public function uploadNewImageByUrl($urls, $type) {
        if ($urls) {
            if (!is_array($urls)) {
                $urls = explode(',', $urls);
            }
            foreach ($urls as $url) {
                Image::createImageFromTemp($this, $url, $this->getDir(), $type);
            }
        }
        return $this;
    }
}
