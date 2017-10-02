<?php

namespace app\controllers;

use app\components\Helper;
use app\models\Category;
use app\models\Place;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\PlaceForm;

class PlaceController extends BaseMapController
{

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
                    ->select(['name', 'lat', 'lon', 'description', 'address', 'updated_at'])
                    ->asArray()->all();

                $model['places'] = $places;
            }
            $response[] = $model;
        }
        return $response;
    }

}
