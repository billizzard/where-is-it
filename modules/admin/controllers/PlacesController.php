<?php

namespace app\modules\admin\controllers;

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
    public function actions()
    {
        return [
            'delete' => [
                'class' => DeleteAction::className(),
                'model_class' => Place::className(),
            ],
        ];
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors(); // TODO: Change the autogenerated stub
        $behaviors['access']['rules'][] = [
            'actions' => ['remove-image'],
            'allow' => true,
            'roles' => [User::ROLE_ADMIN],
        ];
        return $behaviors;
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PlaceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

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
                $this->uploadMainImage($model, $modelImage);
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
        $modelImage = new Image();

        if ($model->load(Yii::$app->request->post()) && $modelImage->load(Yii::$app->request->post())) {
            if ($model->save()) {
                $this->uploadMainImage($model, $modelImage);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelImage' => $modelImage,
        ]);
    }

    private function uploadMainImage(Place $model, Image $modelImage) {
        $modelImage->url = UploadedFile::getInstance($modelImage, 'image');
        if ($modelImage->url) {
            if ($oldImage = $model->mainImage) {
                $oldImage->delete();
            }
            $modelImage->upload($model);
            $modelImage->place_id = $model->id;
            $modelImage->save();
        }
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