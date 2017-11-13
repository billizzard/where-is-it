<?php

namespace app\models\traits;

use app\constants\ImageConstants;
use app\models\Image;

trait UrlImageUploader
{
    abstract public function getDir();

//    public function stayOnlyImageByUrl($urls) {
//        if ($urls) {
//            if (!is_array($urls)) {
//                $urls = explode(',', $urls);
//            }
//            $images = $this->images;
//
//            /** @var Image $image */
//            foreach ($images as $image) {
//                if (in_array('/' . $image->url, $urls)) {
//                    Image::createImageFromTemp($this, '/' . $image->url, $this->getDir(), ImageConstants::TYPE['GALLERY']);
//                }
//            }
//        }
//        return $this;
//    }

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
