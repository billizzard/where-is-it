<?php
namespace app\components\widgets\imageUploader;

use yii\base\Widget;

class ImageUploaderWidget extends Widget
{
    private $default = [
        'inputFileName' => 'files',
        'inputUrlName' => 'images',
        'uploadUrl' => '',
        'maxFiles' => 1,
        'errorCallback' => '',
        'deleteUrl' => '',
        'deleteButton' => true,
        'uploadButton' => true,
        'oldImages' => []
    ];

    public $config = [];

    public function init()
    {
        parent::init();
        $this->setConfig();
        $this->registerAssets();
    }

    public function run()
    {
        return $this->render('imageUploader', $this->config);
    }

    public function registerAssets()
    {
        $view = $this->getView();
        ImageUploaderAsset::register($view);
    }

    private function setConfig()
    {
        if ($this->config) {
            foreach ($this->default as $key => $val) {
                $this->config[$key] = $this->config[$key] ?? $val;
            }
        } else {
            $this->config = $this->default;
        }
    }


}