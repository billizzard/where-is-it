<?php
namespace app\modules\admin\components;
use app\constants\UserConstants;
use app\models\User;

class AccessRule extends \yii\filters\AccessRule {

    public $className;

    /**
     * @inheritdoc
     */
    protected function matchRole($user)
    {
        if (empty($this->roles)) {
            return true;
        }
        foreach ($this->roles as $role) {
            if ($role === '?') {
                return true;
            } elseif ($role === '@') {

                if (!$user->getIsGuest()) {
                    return true;
                }

            } elseif (!$user->getIsGuest() && $role === $user->identity->role) {

                if ($role === UserConstants::ROLE['OWNER']) {
                    if ($this->className) {
                        $model = $this->className::findOne((int)$_GET['id']);
                        if ($user->getIdentity()->hasAccess(UserConstants::RULE['OWNER'], ['model' => $model])) {
                            return true;
                        }
                    }
                } else {
                    return true;
                }

            }
        }

        return false;
    }
}