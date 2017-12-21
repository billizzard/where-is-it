<?php

namespace app\modules\admin\controllers;

use app\components\Helper;
use app\components\SiteException;
use app\constants\UserConstants;
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
    protected function getClassName()
    {
        return Schedule::className();
    }

    public function behaviors()
    {
        $rules = parent::behaviors();
        $rules['access']['rules'][] = [
                'actions' => ['soft-delete'],
                'allow' => true,
                'roles' => [UserConstants::ROLE['ADMIN']],
                'className' => Schedule::className()
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

    public function actionCreate($place_id)
    {
        $this->isCanAddMore($place_id);
        $model = new Schedule();
        $model->place_id = $place_id;

        if ($model->load(Yii::$app->request->post())) {
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
        $this->isCanAddMore($model->place_id);

        if ($model->load(Yii::$app->request->post())) {
            $clone = $model->getDuplicate();
            $clone->fromPost(Yii::$app->request->post());
            $clone->save();
            if (Yii::$app->request->post('copy')) {
                return $this->redirect(['copy-to-parent', 'id' => $id]);
            }

            Helper::setMessage('Изменения сохранены, ожидают проверки', Helper::TYPE_MESSAGE_SUCCESS);

            return $this->redirect(['index', 'place_id' => $clone->place_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

}