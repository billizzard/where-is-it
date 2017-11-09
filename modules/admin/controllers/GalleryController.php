<?php

namespace app\modules\admin\controllers;

use app\components\SiteException;
use app\constants\ImageConstants;
use app\models\Category;
use app\models\City;
use app\models\Gallery;
use app\models\Image;
use app\models\Place;
use app\models\Schedule;
use app\modules\admin\components\AccessRule;
use app\modules\admin\components\DeleteAction;
use app\modules\admin\models\search\CategorySearch;
use app\modules\admin\models\search\CitySearch;
use app\modules\admin\models\search\GallerySearch;
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


    public function actionIndex($place_id)
    {
        $searchModel = new GallerySearch();
        $params = Yii::$app->request->queryParams;
        $params['GallerySearch']['place_id'] = $place_id;

        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'isCanAdd' => Gallery::isCanAdd($place_id)
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