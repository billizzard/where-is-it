<?php

namespace app\modules\admin\components\actions;

use app\components\SiteException;
use \Yii;
use yii\base\Action;

class SoftDeleteAction extends Action
{
    public $model_class;

    public function run($id)
    {
        $model_name = $this->model_class;
        $model = $model_name::findOneModel($id);

        if (!$model->softDelete()) throw new SiteException('Не удалось удалить');

        return $this->controller->redirect(Yii::$app->request->getReferrer());
    }
}