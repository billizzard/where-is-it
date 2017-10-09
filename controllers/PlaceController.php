<?php

namespace app\controllers;

use app\components\Helper;
use app\models\Category;
use app\models\Place;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\PlaceForm;

class PlaceController extends BaseMapController
{
    public function actionIndex($id) {
        $model = Place::findPlaceById($id)->one();
        if (!$model) throw new NotFoundHttpException();
        return $this->render('index', [
            'model' => $model,
            'mainImage' => $model->mainImage
        ]);

    }

    public function actionGetByCategory()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $post = Yii::$app->request->post();
        $response = [];
        if (isset($post['category_id'])) {
            $category = Category::findOne((int)$post['category_id']);
            $model = [];
            if ($category && is_array($post['size']) && (count($post['size']) == 2)) {
                $model['color'] = $category->color;

                $places = Place::findByCategoryId($post['category_id'], $post['size'])
                    ->select(['id', 'name', 'lat', 'lon', 'yes', 'no', 'type', 'work_time', 'description', 'address', 'updated_at'])
                    ->asArray()->all();

                foreach ($places as $key => $val) {
                    $places[$key]['work_time'] = nl2br($val['work_time']);
                    $places[$key]['description'] = nl2br($val['description']);
                }
                $model['places'] = $places;
            }
            $response[] = $model;
        }
        return $response;
    }

}
