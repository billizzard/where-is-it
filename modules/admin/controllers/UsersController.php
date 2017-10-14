<?php

namespace app\modules\admin\controllers;

use app\modules\admin\components\AccessRule;
use app\modules\admin\components\DeleteAction;
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
class UsersController extends BaseController
{

    public function actions()
    {
        return [
            'delete' => [
                'class' => DeleteAction::className(),
                'model_class' => User::className(),
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
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
        $user = User::findOne($id);
        if (!$user) return Yii::$app->response->redirect('/admin/users/index');
        return $this->render('view', [
            'model' => $user,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
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
        $model = User::findOne($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
//
//    /**
//     * Deletes an existing User model.
//     * If deletion is successful, the browser will be redirected to the 'index' page.
//     * @param integer $id
//     * @return mixed
//     */
//    public function actionDelete($id)
//    {
//
//        $connection = Yii::$app->getDb();
//
//        // Лайки
//        $connection->createCommand()->delete('user_like', ['like_from_user_id' => $id])->execute();
//
//        // Чаты. Удаляем те, где он создатель
//        $connection->createCommand()->delete('chats', ['creator_id' => $id])->execute();
//
//
//        $connection->createCommand()->delete('chat_users', ['user_id' => $id])->execute();
//
//
//
//
//        $this->findModel($id)->delete();
//
//
//        //$connection->createCommand()->delete('profile', ['creator_id' => $id])->execute();
//
//
//        return $this->redirect(['index']);
//    }



}