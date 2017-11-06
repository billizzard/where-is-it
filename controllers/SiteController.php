<?php

namespace app\controllers;

use app\components\Geo;
use app\components\Helper;
use app\constants\AppConstants;
use app\constants\MessageConstants;
use app\models\Message;
use app\models\Place;
use app\models\RegistrationForm;
use app\models\Review;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
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

    public function actionFeedback() {
        $get = Yii::$app->request->get();
        if ($get['type'] == MessageConstants::TYPE['COMPLAIN']) {
            $model = new Message();
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Helper::setMessage('Сообщение успешно отправлено.', Helper::TYPE_MESSAGE_SUCCESS);
                return $this->redirect('/feedback/');
            }
        } else {
            throw new NotFoundHttpException();
        }

        $type = $get['type'];

        $place = null;
        if (isset($get['place_id'])) {
            $place = Place::findPlaceById($get['place_id'])->one();
            if ($place) {
                $model->place_id = $place->id;
            }
        }

        return $this->render('message', [
            'model' => $model,
            'place' => $place,
            'type' => $type
        ]);
    }

    private function saveMessage(Message $model) {
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Helper::setMessage('Сообщение успешно отправлено.', Helper::TYPE_MESSAGE_SUCCESS);
            return $this->redirect('/feedback/');
        }
    }

}
