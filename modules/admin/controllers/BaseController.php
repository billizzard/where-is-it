<?php

namespace app\modules\admin\controllers;

use app\components\SiteException;
use app\models\User;
use app\modules\admin\components\AccessRule;
use app\modules\admin\components\actions\DeleteAction;
use app\modules\admin\components\actions\SoftDeleteAction;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Default controller for the `admin` module
 */
class BaseController extends Controller
{
    public $layout = 'main';

    protected function getClassName() {
        return false;
    }

    public function actions()
    {
        return [
            'delete' => [
                'class' => DeleteAction::className(),
                'model_class' => $this->getClassName()
            ],
            'soft-delete' => [
                'class' => SoftDeleteAction::className(),
                'model_class' => $this->getClassName()
            ],
        ];
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
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
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Проверяет, может ли пользователь добавлять еще модели к месту
     * @param $place_id
     * @return bool
     * @throws SiteException
     */
    protected function isCanAddMore($place_id) {
        if ($className = $this->getClassName()) {
            if ($this->getClassName()::isCanAddMore($place_id)) {
                return true;
            }
        }
        throw new SiteException('Действие запрещено', 404);
    }

}
