<?php

namespace app\modules\admin\controllers;

use app\constants\ImageConstants;
use app\models\Category;
use app\models\Image;
use app\models\Place;
use app\models\traits\ImageUploaderController;
use app\modules\admin\components\actions\DeleteAction;
use app\modules\admin\models\search\PlaceSearch;
use Yii;
use app\models\User;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * UsersController implements the CRUD actions for User model.
 */
class PlacesController extends BaseController
{
    use ImageUploaderController;

    protected function getClassName() {
        return Place::className();
    }

    public function getScenario()
    {
        return ImageConstants::SCENARIO['MAIN_PLACE'];
    }

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
                'actions' => ['update'],
                'allow' => true,
                'roles' => ['?'],
            ],
            [
                'actions' => ['upload-image'],
                'allow' => true,
                'roles' => ['?'],
            ],
            [
                'actions' => ['remove-image'],
                'allow' => true,
                'roles' => ['@'],
            ],
            [
                'actions' => ['soft-delete'],
                'allow' => true,
                'roles' => [User::ROLE_ADMIN],
            ]
        ];

        return $rules;

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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Place();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->uploadNewImageByUrl(Yii::$app->request->post('images'), ImageConstants::TYPE['MAIN_PLACE']);
            return $this->redirect(['index', 'place_id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = Place::findOneModel($id);

        if ($model->load(Yii::$app->request->post()) ) {
            if ($post = Yii::$app->request->post()) {

                /** @var Place $newModel */
                $newModel = $model->getDuplicate();

                if ($newModel->load(Yii::$app->request->post()) && $newModel->save()) {
                    $newModel->uploadNewImageByUrl(
                        array_merge(explode(',',$post['old_images']),explode(',',$post['images'])),
                        ImageConstants::TYPE['MAIN_PLACE']);
                    return $this->redirect(['index', 'place_id' => $newModel->id]);
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
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
                    if ($user->hasAccess(User::RULE_OWNER, ['model' => $image])) {
                        $image->delete();
                        return true;
                    }
                }
            }
            return false;
        }
    }


}