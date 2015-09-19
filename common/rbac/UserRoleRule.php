<?php

namespace common\rbac;

use  yii\rbac\Rule;
use Yii;
use common\models\User;



class UserRoleRule extends Rule {

    public $name = 'userRole';

    public function execute($user, $item, $params) {

        if (Yii::$app->user->isGuest) {
            return false;
        }

        $role = Yii::$app->user->identity->role;

        if ($item->name === 'admin') {
            return $role == User::ROLE_ADMIN;
        }
        elseif ($item->name === 'inspector') {
            return  $role == User::ROLE_ADMIN || $role == User::ROLE_INSPECTOR;
        }
        elseif ($item->name === 'localAdmin') {
            return $role == User::ROLE_ADMIN || $role == User::ROLE_LOCAL_ADMIN;
        }
        elseif ($item->name === 'student') {
            return $role == User::ROLE_ADMIN || $role === User::ROLE_STUDENT;
        }
        else
            return false;

    }

} 