<?php

namespace app\modules\admin\controllers;

use app\constants\AppConstants;
use app\models\Category;
use app\models\City;
use app\models\Discount;
use app\models\Image;
use app\models\Schedule;
use app\modules\admin\components\AccessRule;
use app\modules\admin\components\DeleteAction;
use app\modules\admin\models\search\CategorySearch;
use app\modules\admin\models\search\CitySearch;
use app\modules\admin\models\search\DiscountSearch;
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
class DiscountsController extends BaseController
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
        $searchModel = new DiscountSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate($place_id)
    {
        $model = new Discount();
        $model->place_id = (int)$place_id;
        $modelImage = new Image();

        if ($model->load(Yii::$app->request->post()) && $modelImage->load(Yii::$app->request->post())) {
            if ($model->save()) {
                $modelImage->uploadDiscountImage($model);
                return $this->redirect(['index', 'place_id' => $model->place_id]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'modelImage' => $modelImage,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = Discount::findOne($id);
        if (!$model) throw new NotFoundHttpException();
        $noCheckModel = $model->getNoCheckModel();
        $modelImage = new Image();

        if ($model->load(Yii::$app->request->post()) && $modelImage->load(Yii::$app->request->post())) {
            /** @var User $user */
            $user = \Yii::$app->user->getIdentity();
            if ($user && $user->hasAccess(User::RULE_OWNER, ['model' => $model->place])) {
                if ($model->save()) {
                    $modelImage->uploadDiscountImage($model);
                }
            } else {
                if ($model->save()) {
                    $modelImage->uploadDiscountImage($model);
                }
            }
            return $this->redirect(['index', 'place_id' => $model->place_id]);

        }

        return $this->render('update', [
            'model' => $model,
            'modelImage' => $modelImage,
            'noCheckModel' => $noCheckModel,
        ]);

    }

}