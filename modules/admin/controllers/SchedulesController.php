<?php

namespace app\modules\admin\controllers;

use app\constants\AppConstants;
use app\models\Category;
use app\models\City;
use app\models\Schedule;
use app\modules\admin\components\AccessRule;
use app\modules\admin\components\DeleteAction;
use app\modules\admin\models\search\CategorySearch;
use app\modules\admin\models\search\CitySearch;
use app\modules\admin\models\search\ScheduleSearch;
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
            [
                'actions' => ['create'],
                'allow' => true,
                'roles' => ['?'],
            ],
            [
                'actions' => ['update'],
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
        $searchModel = new ScheduleSearch();
        $params = Yii::$app->request->queryParams;
        $params['ScheduleSearch']['place_id'] = $place_id;

        $dataProvider = $searchModel->search($params);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionCreate($place_id)
    {
        $model = new Schedule();
        $model->place_id = $place_id;

        if (Yii::$app->request->post()) {
            $model->fromPost(Yii::$app->request->post());
            $model->save();
            return $this->redirect(['index', 'place_id' => $model->place_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($place_id)
    {
        $model = Schedule::findByPlaceAndStatus($place_id, AppConstants::STATUS['MODERATE'])->one();

        if (Yii::$app->request->post()) {
            if ($id = $model->id) {
                $model = new Schedule();
                $model->parent_id = $id;
            }
            $model->fromPost(Yii::$app->request->post());
            $model->save();
            $noCheckModel = $model;
        }

        return $this->render('index', [
            'model' => $model,
            'noCheckModel' => $noCheckModel
        ]);
    }



}