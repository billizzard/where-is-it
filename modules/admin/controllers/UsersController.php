<?php

namespace app\modules\admin\controllers;

use app\components\SiteException;
use app\constants\UserConstants;
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
use yii\web\Response;

/**
 * UsersController implements the CRUD actions for User model.
 */
class UsersController extends BaseController
{
    protected function getClassName()
    {
        return User::className();
    }

    public function behaviors()
    {
        $rules = parent::behaviors();

        $rules['access']['rules'] = [
            [
                'actions' => ['delete'],
                'allow' => true,
                'roles' => [UserConstants::ROLE['ADMIN']],
            ],
            [
                'actions' => ['index'],
                'allow' => true,
                'roles' => ['@'],
            ],
            [
                'actions' => ['create'],
                'allow' => true,
                'roles' => [UserConstants::ROLE['ADMIN']],
            ],
            [
                'actions' => ['update'],
                'allow' => true,
                'roles' => ['@'],
            ],
            [
                'actions' => ['avatars'],
                'allow' => true,
                'roles' => ['@'],
            ],
            [
                'actions' => ['soft-delete'],
                'allow' => true,
                'roles' => [UserConstants::ROLE['ADMIN']],
                'className' => $this->getClassName()
            ]
        ];

        return $rules;
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        /** @var User $user */
        $user = Yii::$app->user->getIdentity();
        $searchModel = new UserSearch();
        $params = Yii::$app->request->queryParams;
        if (!$user->isAdmin()) {
            $params['UserSearch']['id'] = $user->getId();
        }
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
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
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
            if ($model->new_password) {
                $model->setScenario(UserConstants::SCENARIO['CHANGE_PASSWORD']);
                if ($model->validate()) {
                    $model->setScenario(User::SCENARIO_DEFAULT);
                    $model->setPassword($model->new_password);
                    $model->save();
                    return $this->redirect(['index']);
                }
            } else {
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionAvatars(int $user_id, int $page = 1)
    {
        if (($post = Yii::$app->request->post()) && Yii::$app->request->post('src')) {
            /** @var User $user */
            $user = Yii::$app->user->getIdentity();
            if ($user->isAdmin()) {
                $user = User::findOneModel($user_id);
            }
            Yii::$app->response->format = Response::FORMAT_JSON;
            if (file_exists(Yii::getAlias('@webroot') . $post['src'])) {
                $info = pathinfo($post['src']);
                $user->setAvatar($info['basename']);
                $user->save();
                return true;
            }
            return false;
        }
        $perPage = 30;
        $finish = $page * $perPage + 2;
        $start = $finish - $perPage;
        $files = scandir(Yii::getAlias('@webroot' . '/img/avatars/mult/'));
        $avatars = [];
        $countPages = ceil(count($files)/$perPage);

        if ($start > 1 && isset($files[$start])) {
            for ($i = $start; $i < $finish; $i++) {
                if (isset($files[$i])) {
                    $avatars[] = $files[$i];
                }
            }
        } else {
            throw new SiteException('Страница не найдена', 404);
        }

        
        return $this->render('avatars', [
            'avatars' => $avatars,
            'countPages' => $countPages,
        ]);
    }

}