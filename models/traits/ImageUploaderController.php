<?php

namespace app\models\traits;

use app\models\Image;
use yii\web\Response;

trait ImageUploaderController
{
    abstract function getScenario();

    /**
     * Экшен для загрузки изображений через ajax
     * @return array - массив изображений
     */
    public function actionUploadImage() {
        $url = [];
        $modelImage = new Image(['scenario' => $this->getScenario()]);
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if (\Yii::$app->request->post()) {
            if ($modelImage->load(\Yii::$app->request->post())) {
                $url = $modelImage->uploadTempImages();
            }
        }

        return $this->getResultUrlArr($url);
    }

    /**
     * Указывает какие выбирать из массива для возвращения
     * @return string
     */
    protected function getPrefix() {
        return 'original';
    }

    /**
     * Из массива нарезанных изображений, возвращает те, которые нужны
     * @param $url
     * @return array
     */
    private function getResultUrlArr($url) {
        $res = [];
        $prefix = $this->getPrefix();
        if (is_array($url)) {
            foreach ($url as $val) {
                if (isset($val[$prefix])) {
                    $res[] = $val[$prefix];
                }
            }
        }
        return $res;
    }

}
