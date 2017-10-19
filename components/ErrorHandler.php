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

        //if (YII_ENV !== 'prod') {
        if (true) {
            parent::renderException($exception);
        } else {
            if ($exception->getCode() == 403) {
                Helper::setMessage('Доступ запрещен');
                header('Location: /auth/');
                die();
            } else if ($exception->getCode() == 400) {
                $this->getAnswer($exception);
            } else if ($exception->getCode() == 404) {
                header('Location: /404');
                die();
            }
        }

    }

    private function getAnswer($exception)
    {

        if ($exception->getType() == 'api') {
            $response = \Yii::$app->response;
            $response->format = Response::FORMAT_JSON;
            $response->data = ['message' => $exception->getMessage()];
            $response->statusCode = $exception->getCode();
            $response->send();
        } else {
            Helper::setMessage($exception->getMessage());
            \Yii::$app->response->redirect(\Yii::$app->request->referrer)->send();

        }
    }
}