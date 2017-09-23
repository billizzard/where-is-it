<?php

namespace app\modules\admin\components;

use app\models\User;
use \Yii;
use yii\base\Action;
use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\helpers\Url;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class DeleteAction extends Action
{
    public $model_class;
    public $has_access = false;


    public function run($id)
    {
        //if (!$this->has_access) throw new ForbiddenHttpException('У вас не достаточно прав');
        $model_name = $this->model_class;
        $model = $model_name::findOne($id);
        if (!$model) throw new NotFoundHttpException();

        if (!$model->delete()) throw new NotFoundHttpException('Не удалось удалить');

        return $this->controller->redirect(Yii::$app->request->getReferrer());
    }
}