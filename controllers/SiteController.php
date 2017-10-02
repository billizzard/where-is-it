<?php

namespace app\controllers;

use app\components\Geo;
use app\components\Helper;
use app\models\Place;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\PlaceForm;

class SiteController extends BaseMapController
{

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionAdd()
    {
        $model = new Place();
        if (Yii::$app->request->post()) {

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Helper::setMessage('После проверки, точка появится на карте', Helper::TYPE_MESSAGE_SUCCESS);
                return $this->refresh();
            } else {
                Helper::setMessage($model->getErrors());
            }
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionError404()
    {
        return $this->render('error_404');
    }

}
