<?php

namespace common\rbac;


use yii\rbac\Rule;
use Yii;
use common\models\User;


class UserFacultyRule extends Rule {

    public $name = 'isOwnFaculty';


    public function execute($user, $item, $params) {

        if (Yii::$app->user->isGuest)
            return false;

        if (Yii::$app->user->identity->role == User::ROLE_ADMIN) {
            return true;
        }

        return  isset($params['id_faculty']) && $params['id_faculty'] ?
            $params['id_faculty'] == Yii::$app->user->identity->id_faculty : true;
    }


} 