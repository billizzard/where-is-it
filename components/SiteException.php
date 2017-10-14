<?php

namespace app\components;


use yii\base\Exception;

class SiteException extends Exception
{
    private $type = 'site';

    public function getType() {
        return $this->type;
    }

    public function __construct($message, $code = 0) {
        if (is_array($message)) {
            $message = array_shift($message)[0];
        }
        parent::__construct($message, $code);
    }
}