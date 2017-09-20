<?php

namespace app\components;



use yii\web\Response;

class ErrorHandler extends \yii\web\ErrorHandler
{

    /**
     * @inheridoc
     */

    protected function renderException($exception)
    {
        if (YII_ENV !== 'prod') {
            parent::renderException($exception);
        } else {
            if ($exception->statusCode == 403) {
                Helper::setErrors('Доступ запрещен');
                header('Location: /admin/auth');
                die();
            } else if ($exception->statusCode == 404) {
                header('Location: /404');
                die();
            }
        }

    }
}