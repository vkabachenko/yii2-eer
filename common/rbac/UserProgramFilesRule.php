<?php

namespace common\rbac;


use common\helpers\YearHelper;
use common\models\Program;
use common\models\StudentEducation;
use yii\rbac\Rule;
use Yii;
use common\models\User;

class UserProgramFilesRule extends Rule {

    public $name = 'isProgramFiles';


    public function execute($user, $item, $params) {

        if (Yii::$app->user->isGuest)
            return false;

        $role = Yii::$app->user->identity->role;

        if ($role == User::ROLE_ADMIN) {
            return true;
        }
        elseif (!isset($params['id_program'])) {
            return false;
        }
        elseif  ($role == User::ROLE_STUDENT) {
            $model = StudentEducation::find()->
                where([
                    'id_student' => Yii::$app->user->identity->id_student,
                    'year' => YearHelper::getYear(),
                ])->one();

            if (!$model)
                return false;
            else
                return $params['id_program'] == $model->id_program;
        }
        elseif ($role == User::ROLE_LOCAL_ADMIN || $role == User::ROLE_INSPECTOR) {
            $model = Program::findOne($params['id_program']);
            if (!$model)
                return false;
            else
                return Yii::$app->user->identity->id_faculty == $model->id_faculty;
        }
        else
            return false;
    }
} 