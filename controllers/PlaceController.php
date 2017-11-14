<?php

namespace app\controllers;

use app\components\ApiException;
use app\components\file\FileHelper;
use app\components\file\ImageMainHandler;
use app\components\Helper;
use app\components\SiteException;
use app\constants\ImageConstants;
use app\constants\MessageConstants;
use app\models\Category;
use app\models\Image;
use app\models\Place;
use app\models\Review;
use app\models\Star;
use app\models\traits\ImageUploaderController;
use app\models\User;
use app\models\Vote;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\PlaceForm;

class PlaceController extends BaseMapController
{
    use ImageUploaderController;

    public function getScenario()
    {
        return ImageConstants::SCENARIO['TEMP'];
    }

    public function actionIndex($id)
    {
        $this->layout = 'placeLayout';
        $model = Place::findByIdAndStatus($id)->one();
        if (!$model) throw new NotFoundHttpException();
        $this->view->params['model'] = $model;
        return $this->render('index', [
            'model' => $model,
        ]);

    }

    public function actionGallery($id) {
        $this->layout = 'placeLayout';
        /** @var Place $model */
        $model = Place::findByIdAndStatus($id)->one();
        if (!$model) throw new NotFoundHttpException();
        $gallery = $model->gallery;
        if (!$gallery) throw new NotFoundHttpException();
        $this->view->params['model'] = $model;
        return $this->render('gallery', [
            'galleries' => $gallery
        ]);
    }

    public function actionSchedule($id) {
        $this->layout = 'placeLayout';
        /** @var Place $model */
        $model = Place::findByIdAndStatus($id)->one();
        if (!$model) throw new NotFoundHttpException();
        $schedule = $model->schedule;
        if (!$schedule) throw new NotFoundHttpException();
        $this->view->params['model'] = $model;
        return $this->render('schedule', [
            'schedule' => $schedule
        ]);
    }

    public function actionGetByCategory()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $post = Yii::$app->request->post();
        $response = [];
        if (isset($post['category_id'])) {
            $category = Category::findOne((int)$post['category_id']);
            $model = [];
            if ($category && is_array($post['size']) && (count($post['size']) == 2)) {
                $model['color'] = $category->color;

                $places = Place::getForMapByCategoryId($post['category_id'], $post['size']);

                foreach ($places as $key => $val) {
                    $places[$key]['url'] = ImageMainHandler::getAllImages($places[$key]['url']);
                    $places[$key]['prev_description'] = $val['prev_description'] ? nl2br($val['prev_description']) : 'Нет краткого описания';
                }
                $model['places'] = $places;
            }
            $response[] = $model;
        }

        return $response;
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionAdd()
    {
        $model = new Place();

        if (Yii::$app->request->post()) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Helper::setMessage('После проверки, точка появится на карте (<a href="/admin/places/?place_id=' . $model->id . '" target="_blank">заполнить детально</a>).', Helper::TYPE_MESSAGE_SUCCESS);
                if ($imageUrl = Yii::$app->request->post('image')) {
                    $model->uploadNewImageByUrl($imageUrl, ImageConstants::TYPE['MAIN_PLACE']);
                    //Image::createMainImageFromTemp($model, $imageUrl);
                }
                return $this->refresh();
            } else {
                Helper::setMessage($model->getErrors());
            }
        }

        return $this->render('add', [
            'model' => $model,
        ]);
    }

    public function actionVote()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $post = Yii::$app->request->post();
        if (isset($post['vote']) && isset($post['placeId'])) {
            /** @var Place $place */
            $place = Place::findPlaceById($post['placeId'])->one();
            if ($place) {
                $vote = Vote::findByPlaceAndIp($place->id)->one();
                if ($vote) {
                    if ($vote->created_at > (time() - 60 * 60 * 24 * 7 * 4)) {
                        throw new ApiException('Вы уже голосовали в этом месяце', 403);
                    }
                } else {
                    $vote = new Vote();
                    $vote->ip = ip2long($_SERVER['REMOTE_ADDR']);
                    $vote->place_id = $place->id;
                }

                if ($post['vote'] === 'yes') {
                    $vote->vote = true;
                    $place->yes++;
                } else {
                    $vote->vote = false;
                    $place->no++;
                }
                if ($vote->save()) {
                    $place->save();
                    return ['success' => true];
                }

            }
        }
        throw new ApiException('Не удалось записать голос. Попробуйте позже');
    }

    public function actionReview($place_id, $type, $star)
    {
        /** @var User $user */
        $user = Yii::$app->user->getIdentity();
        $model = new Review();
        /** @var Place $place */
        $place = Place::findPlaceById($place_id)->one();
        if (!$place) throw new NotFoundHttpException();

        if ($type == MessageConstants::TYPE['REVIEW']) {
            if ($user) {

                if ($model->load(Yii::$app->request->post())) {
                    $model->star = $model->star > 5 ? 5 : $model->star;
                    $model->star = $model->star < 1 ? 1 : $model->star;
                    if ($user->isCanPostReviewOnPlace($place->id)) {
                        $model->user_id = $user->id;
                        if ($model->save()) {
                            $place->setStars();
                            $place->save();
                            Helper::setMessage('Отзыв успешно отправлен.', Helper::TYPE_MESSAGE_SUCCESS);
                            return $this->redirect(Helper::getCurrentUrl());
                        } else {
                            throw new SiteException($model->getErrors(), 400);
                        }
                    }
                }
            } else {
                Helper::setMessage('Только зарегистрированные пользователи могут оставлять отзывы (<a href="/login/">Войти</a>).');
            }
        } else {
            throw new NotFoundHttpException();
        }

        $model->star = (int)$star;
        $model->place_id = $place->id;

        return $this->render('review', [
            'model' => $model,
            'place' => $place,
        ]);
    }

}
