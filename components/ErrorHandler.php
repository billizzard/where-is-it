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
        if (YII_ENV === 'prod') {
            parent::renderException($exception);
        } else {
            if ($exception->getCode() == 403) {
                Helper::setMessage('Доступ запрещен');
                header('Location: /auth/');
                die();
            } else if ($exception->getCode() == 404) {
                header('Location: /404');
                die();
            } else {
                $this->getAnswer($exception);
            }
        }

    }

    private function getAnswer($exception)
    {
        if (\Yii::$app->request->isAjax) {
            $response = \Yii::$app->response;
            $response->format = Response::FORMAT_JSON;
            $response->data = ['message' => $exception->getMessage()];
            $response->statusCode = $exception->getCode() ? $exception->getCode() : 400;
            $response->send();
        } else {
            if ($exception->statusCode) {
                $code = \Yii::$app->request->referrer ? \Yii::$app->request->referrer : '/404';
                Helper::setMessage($exception->getMessage());
                \Yii::$app->response->redirect($code)->send();
            }

        }
    }
}