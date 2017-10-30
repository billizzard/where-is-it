<?php

namespace app\modules\admin\controllers;

use app\constants\AppConstants;
use app\models\Category;
use app\models\City;
use app\models\Image;
use app\models\Place;
use app\modules\admin\components\AccessRule;
use app\modules\admin\components\DeleteAction;
use app\modules\admin\models\search\CategorySearch;
use app\modules\admin\models\search\CitySearch;
use app\modules\admin\models\search\PlaceSearch;
use Yii;
use app\models\User;
use app\modules\admin\models\search\UserSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * UsersController implements the CRUD actions for User model.
 */
class PlacesController extends BaseController
{
    public function behaviors()
    {
        $rules = parent::behaviors();
        $rules['access']['rules'] = [
            [
                'actions' => ['delete'],
                'allow' => true,
                'roles' => [User::ROLE_ADMIN],
            ],
            [
                'actions' => ['index'],
                'allow' => true,
                'roles' => ['?'],
            ],
            [
                'actions' => ['create'],
                'allow' => true,
                'roles' => [User::ROLE_ADMIN],
            ],
            [
                'actions' => ['view'],
                'allow' => true,
                'roles' => ['?'],
            ],
            [
                'actions' => ['update'],
                'allow' => true,
                'roles' => ['?'],
            ],
            [
                'actions' => ['remove-image'],
                'allow' => true,
                'roles' => [User::ROLE_ADMIN],
            ]
        ];

        return $rules;

    }

    public function actions()
    {
        return [
            'delete' => [
                'class' => DeleteAction::className(),
                'model_class' => Place::className(),
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex($place_id = false)
    {
        $params = Yii::$app->request->queryParams;

        if ($place_id = (int)$place_id) {
            $params['PlaceSearch']['id'] = $place_id;
            $_SESSION['place_id'] = $place_id;
        } else {
            unset($_SESSION['place_id']);
        }

        $searchModel = new PlaceSearch();
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = Place::findOne($id);
        if (!$model) return Yii::$app->response->redirect('/admin/places/index');

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Place();
        $modelImage = new Image();

        if ($model->load(Yii::$app->request->post()) && $modelImage->load(Yii::$app->request->post())) {
            if ($model->save()) {
                $modelImage->uploadMainImage($model);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'modelImage' => $modelImage,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = Place::findOne($id);
        $noCheckModel = Place::findByStatus(AppConstants::STATUS['NO_MODERATE'])->one();
        $modelImage = new Image();

        if ($model->load(Yii::$app->request->post()) && $modelImage->load(Yii::$app->request->post())) {
            /** @var User $user */
            $user = \Yii::$app->user->getIdentity();
            if (!$user || !$user->hasAccess(User::RULE_OWNER, ['model' => $this])) {
                if (!$noCheckModel) {
                    $clone = new Place();
                    $clone->attributes = $model->attributes;
                    $clone->parent_id = $model->id;
                    $clone->save();
                    $modelImage->uploadMainImage($clone);
                }
            } else {
                if ($model->save()) {
                    $modelImage->uploadMainImage($model);
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);

        }

        return $this->render('update', [
            'model' => $model,
            'modelImage' => $modelImage,
            'noCheckModel' => $noCheckModel,
        ]);
    }

    public function actionRemoveImage(){
        $user= Yii::$app->user->getIdentity();
        if (Yii::$app->request->isPost && $user) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $id = Yii::$app->request->post('id');
            if ((int)$id) {
                $image = Image::findOne((int)$id);
                if ($image) {
                    if ($user->hasAccess(User::RULE_OWNER, ['model' => $image->place])) {
                        $image->delete();
                        return true;
                    }
                }
            }
            return false;
        }
    }


}