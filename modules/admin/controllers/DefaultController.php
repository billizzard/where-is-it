<?php

namespace app\modules\admin\controllers;

use app\components\Helper;
use app\models\LoginForm;
use app\models\User;
use app\modules\admin\components\AccessRule;
use app\modules\admin\models\search\UserSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

/**
 * Default controller for the `admin` module
 */
class DefaultController extends BaseController
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                // We will override the default rule config with the new AccessRule class
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                //'only' => ['create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['auth'],
                        'allow' => true,
                        'roles' => [
                            '?', '@'
                        ],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        // Allow moderators and admins to update
                        'roles' => [
                            User::ROLE_ADMIN,
                        ],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        // Allow admins to delete
                        'roles' => [
                            User::ROLE_ADMIN
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        \Yii::$app->user->logout();
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionAuth()
    {
        $this->layout = 'main-login';

        /** @var User $user */
        $user = \Yii::$app->user->getIdentity();

        if ($user && $user->hasAccess(User::RULE_ADMIN_PANEL)) {
            return $this->redirect('/admin');
        }

        $model = new LoginForm();

        if (\Yii::$app->request->isPost) {
            $model->load(\Yii::$app->request->post());
            if ($model->login()) {
                if ($user = \Yii::$app->user->getIdentity()) {
                    if ($user->isAdmin()) {
                        return $this->redirect('/admin');
                    } else {
                        Helper::setErrors('Доступ запрещен');
                    }
                }
            }
        }
        
        return $this->render('auth', ['model' => $model]);
    }
}
