<?php

namespace app\modules\admin\controllers;

use app\models\Category;
use app\models\City;
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
class SchedulesController extends BaseController
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
        
        $model = Schedule::findByPlaceId($place_id)->one();

        if (!$model) {
            $model = new Schedule();
        }

        if (Yii::$app->request->post()) {
            $model->fromPost(Yii::$app->request->post());
            $model->save();
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

}