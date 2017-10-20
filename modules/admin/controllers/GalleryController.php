<?php

namespace app\modules\admin\controllers;

use app\models\Category;
use app\models\City;
use app\models\Image;
use app\models\Schedule;
use app\modules\admin\components\AccessRule;
use app\modules\admin\components\DeleteAction;
use app\modules\admin\models\search\CategorySearch;
use app\modules\admin\models\search\CitySearch;
use Yii;
use app\models\User;
use app\modules\admin\models\search\UserSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsersController implements the CRUD actions for User model.
 */
class GalleryController extends BaseController
{

    public function behaviors()
    {
        $rules = parent::behaviors();
        $rules['access']['rules'] = [
            [
                'actions' => ['index'],
                'allow' => true,
                'roles' => ['?'],
            ],
        ];

        return $rules;
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex($place_id)
    {
        $models = Image::findGallery($place_id)->all();

        if (Yii::$app->request->post()) {
            echo "<pre>";
            var_dump(Yii::$app->request->post());
            die();
            $model->fromPost(Yii::$app->request->post());
            $model->save();
        }

        return $this->render('index', [
            'models' => $models,
        ]);
    }

}