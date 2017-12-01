<?php

namespace app\modules\admin\controllers;

use app\components\Helper;
use app\models\Image;
use app\models\LoginForm;
use app\models\RegistrationForm;
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
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => [
                            '?', '@'
                        ],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => [
                            '?', '@'
                        ],
                    ],
                    [
                        'actions' => ['registration'],
                        'allow' => true,
                        'roles' => [
                            '?', '@'
                        ],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => [
                            User::ROLE_ADMIN,
                        ],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => [
                            User::ROLE_ADMIN
                        ],
                    ],
                    [
                        'actions' => ['download-image'],
                        'allow' => true,
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
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionLogin()
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
                        Helper::setMessage('Доступ запрещен');
                    }
                }
            }
        }
        
        return $this->render('auth', ['model' => $model]);
    }

    public function actionLogout()
    {
        \Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionRegistration() {
        $this->layout = 'main-login';
        $model = new RegistrationForm();
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if ($user = $model->registration()) {
                if (\Yii::$app->user->login($user)) {
                    return $this->goBack();
                }
            }
        }
        return $this->render('registration', [
            'model' => $model,
        ]);
    }

    public function actionDownloadImage($id) {
        $image = Image::findOneModel($id);
        if ($image) {
            if(file_exists($image->getUrl())) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="'.basename($image->getUrl()).'"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($image->getUrl()));
                flush(); // Flush system output buffer
                readfile($image->getUrl());
                exit;
            }
        }
    }
}
