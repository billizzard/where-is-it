<?php

namespace app\modules\admin\controllers;

use app\models\Schedule;
use app\models\User;
use app\modules\admin\components\actions\DeleteAction;
use app\modules\admin\components\actions\SoftDeleteAction;
use app\modules\admin\models\search\ScheduleSearch;
use Yii;

/**
 * UsersController implements the CRUD actions for User model.
 */
class SchedulesController extends BaseController
{

    public function actions()
    {
        return [
            'delete' => [
                'class' => DeleteAction::className(),
                'model_class' => Schedule::className()
            ],
            'soft-delete' => [
                'class' => SoftDeleteAction::className(),
                'model_class' => Schedule::className()
            ],
        ];
    }


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
            [
                'actions' => ['soft-delete'],
                'allow' => true,
                'roles' => [User::ROLE_OWNER],
                'className' => Schedule::className()
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
            'isCanAdd' => Schedule::isCanAddMore($place_id)
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

    public function actionUpdate($id)
    {
        $model = Schedule::findOneModel($id);

        if (Yii::$app->request->post()) {
            $clone = $model->getClone();
            $clone->fromPost(Yii::$app->request->post());
            $clone->save();
            return $this->redirect(['index', 'place_id' => $clone->place_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }



}