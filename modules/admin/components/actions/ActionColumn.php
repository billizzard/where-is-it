<?php
namespace app\modules\admin\components\actions;
use app\models\BaseModel;
use yii\bootstrap\Html;

/**
 * Created by PhpStorm.
 * User: v
 * Date: 9.11.17
 * Time: 15.56
 */
class ActionColumn extends \yii\grid\ActionColumn
{
    public $template = "{update_all} {soft_delete} {delete}";

    public $action_prefix = '';

    public $actions = [];

    public $buttons_visible = [];

    public $isUpdatableAll = null;
    public $isSoftDeletableAll = null;

    /**
     * Проверяет можно ли обновить модель. Метод служит для того чтобы снизить нагрузку.
     * Так как для каждой модели, нужен будет запрос в базу для проверки.
     * Проверяет только одни раз для одной модели, для всех остальных будет тот же ответ.
     * @param BaseModel $model
     * @return bool|null
     */
    private function getIsUpdatableAll(BaseModel $model) {
        if ($this->isUpdatableAll === null) {
            $this->isUpdatableAll = $model->isUpdatable();
        }
        return $this->isUpdatableAll;
    }

    /**
     * Проверяет можно ли мягко удалить модель. Метод служит для того чтобы снизить нагрузку.
     * Так как для каждой модели, нужен будет запрос в базу для проверки.
     * Проверяет только одни раз для одной модели, для всех остальных будет тот же ответ.
     * @param BaseModel $model
     * @return bool|null
     */
    private function getIsSoftDeletableAll(BaseModel $model) {
        if ($this->isSoftDeletableAll === null) {
            $this->isSoftDeletableAll = $model->isSoftDeletable();
        }
        return $this->isSoftDeletableAll;
    }

    /**
     * Инициализирует кнопки
     */
    protected function initDefaultButtons()
    {
        $this->initUpdateButton();
        $this->initSoftDeleteButton();
        $this->initDeleteButton();

//
//        if (!isset($this->buttons['arrow_up'])) {
//            $this->buttons['up'] = function ($url, $model) {
//                return Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', $url, [
//                    'title' => 'Поднять выше',
//                    'data-pjax' => '0',
//                ]);
//            };
//        }
//
//        if (!isset($this->buttons['arrow_down'])) {
//            $this->buttons['down'] = function ($url, $model) {
//                return Html::a('<span class="glyphicon glyphicon-arrow-down"></span>', $url, [
//                    'title' => 'Опустить ниже',
//                    'data-pjax' => '0',
//                ]);
//            };
//        }
//
//        if (!isset($this->buttons['cancel'])) {
//            $this->buttons['cancel'] = function ($url, $model) {
//                if (strpos($url, 'new_tab:')) {
//                    $new_tab = true;
//                    $url = str_replace('new_tab:', '', $url);
//                    $url = str_replace('//', '/', $url);
//                } else {
//                    $new_tab = false;
//                }
//                return Html::a('<span class="glyphicon glyphicon-minus"></span>', $url, [
//                    'title' => 'В архив',
//                    'data-pjax' => '0',
//                    'data-confirm' => 'Вы уверены, что хотите отменить?',
//                    'target' => $new_tab ? '_blank' : ''
//                ]);
//            };
//        }
    }

    private function initUpdateButton() {
        if (!isset($this->buttons['update_all'])) {
            $this->buttons['update_all'] = function ($url, $model) {
                if ($this->getIsUpdatableAll($model)) {
                    return Html::a('<span class="glyphicon icon glyphicon-pencil"></span>', str_replace('_all/', '/', $url), [
                        'title' => 'Редактировать',
                        'data-pjax' => '0',
                        'target' => ''
                    ]);
                }
            };
        }
    }

    private function initSoftDeleteButton() {
        if (!isset($this->buttons['soft_delete_all'])) {
            $this->buttons['soft_delete_all'] = function ($url, BaseModel $model) {
                if ($this->getIsSoftDeletableAll($model)) {
                    return Html::a('<span class="glyphicon icon glyphicon-trash"></span>', str_replace('_all/', '/', $url), [
                        'title' => 'Удалить',
                        'data-confirm' => 'Вы уверены, что хотите удалить?',
                        'data-method' => 'post',
                        'data-pjax' => '0',
                    ]);
                }
            };
        }
    }

    private function initDeleteButton() {
        if (!isset($this->buttons['delete'])) {
            $this->buttons['delete'] = function ($url, BaseModel $model) {
                if ($model->isDeletable()) {
                    return Html::a('<span class="glyphicon icon glyphicon-fire"></span>', $url, [
                        'title' => 'Удалить безвозвратно',
                        'data-confirm' => 'Вы уверены, что хотите удалить?',
                        'data-method' => 'post',
                        'data-pjax' => '0',
                    ]);
                }
            };
        }
    }

}