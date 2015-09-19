<?php

namespace common\rbac;

use  yii\rbac\Rule;
use Yii;
use common\models\User;


class UserStudentRule extends Rule {

    public $name = 'isOwnStudent';

    public function execute($user, $item, $params) {

        if (Yii::$app->user->isGuest)
            return false;

        if (Yii::$app->user->identity->role == User::ROLE_ADMIN) {
            return true;
        }

        $id_student = Yii::$app->user->identity->id_student;

        if ($id_student === null) return false;

        if (!isset($params['id_student']) || !$params['id_student']) {
            return true;
        }
        else {
            return $params['id_student'] == $id_student;
        }
    }

} 