<?php

namespace app\modules\admin\controllers;

use app\constants\ImageConstants;
use app\models\Gallery;
use app\models\Image;
use app\models\Schedule;
use app\modules\admin\components\actions\DeleteAction;
use app\modules\admin\components\actions\SoftDeleteAction;
use app\modules\admin\models\search\GallerySearch;
use Yii;
use app\models\User;

/**
 * UsersController implements the CRUD actions for User model.
 */
class GalleryController extends BaseController
{
    public function actions()
    {
        return [
            'delete' => [
                'class' => DeleteAction::className(),
                'model_class' => Gallery::className()
            ],
            'soft-delete' => [
                'class' => SoftDeleteAction::className(),
                'model_class' => Gallery::className()
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
                'className' =>  Gallery::className(),
            ],
        ];

        return $rules;
    }


    public function actionIndex($place_id)
    {
        $searchModel = new GallerySearch();
        $params = Yii::$app->request->queryParams;
        $params['GallerySearch']['place_id'] = $place_id;

        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'isCanAdd' => Gallery::isCanAddMore($place_id)
        ]);
    }

    public function actionCreate($place_id)
    {
        $model = new Gallery();
        $model->place_id = (int)$place_id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($post = Yii::$app->request->post()) {
                if ($post['images']) {
                    $urls = explode(',', $post['images']);
                    foreach ($urls as $url) {
                        Image::createImageFromTemp($model, $url, $model->place->getDir(), ImageConstants::TYPE['GALLERY']);
                    }
                }
            }
            return $this->redirect(['index', 'place_id' => $model->place_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = Gallery::findOneModel($id);

        if ($post = Yii::$app->request->post()) {
            $newGallery = $model->getClone();
            if ($newGallery->load(Yii::$app->request->post()) && $newGallery->save()) {

                if ($post['images']) {
                    $urls = explode(',', $post['images']);
                    foreach ($urls as $url) {
                        Image::createImageFromTemp($newGallery, $url, $model->place->getDir(), ImageConstants::TYPE['GALLERY']);
                    }
                }

                if ($post['old_images']) {
                    $images = $model->images;
                    $imagesOld = explode(',', $post['old_images']);

                    /** @var Image $image */
                    foreach ($images as $image) {
                        if (in_array('/'.$image->url, $imagesOld)) {
                            Image::createImageFromTemp($newGallery, '/'.$image->url, $model->place->getDir(), ImageConstants::TYPE['GALLERY']);
                        }
                    }
                }

                return $this->redirect(['index', 'place_id' => $newGallery->place_id]);

            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);

    }


//    public function actionIndex($place_id)
//    {
//        $model = Place::findOneModel($place_id);
//        $galleryImages = Image::findGallery($place_id)->all();
//        $hasOld = $model->gallery ? true : false;
//        $hasNew = $model->galleryNewVariant ? true : false;
//
//        if ($post = Yii::$app->request->post()) {
//            if ($post['images']) {
//                if ($model->isCanAddGallery()) {
//                    if (!$model->gallery) {
//                        $type = ImageConstants::TYPE['GALLERY'];
//                    } else if (!$model->galleryNewVariant) {
//                        $type = ImageConstants::TYPE['GALLERY_NEW_VARIANT'];
//                    } else {
//                        throw new SiteException('Нельзя добавить, модератор еще не проверил предыдущую галерею');
//                    }
//
//                    $urls = explode(',', $post['images']);
//                    foreach ($urls as $url) {
//                        Image::createMainImageFromTemp($model, $url, $type);
//                    }
//                }
//                $this->refresh();
//            }
//        }
//
//        return $this->render('index', [
//            'models' => $galleryImages,
//            'hasOld' => $hasOld,
//            'hasNew' => $hasNew,
//        ]);
//    }

}