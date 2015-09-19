<?php

namespace console\controllers;

use common\models\User;
use Yii;
use yii\console\Controller;

class AdminController  extends Controller {

    public function actionUser() {

        // create or change global admin user
        User::deleteAll(['username'=>'admin']);

        echo "\n Введите новый пароль администратора или пустую строку для выхода ";
        $passw = trim(fgets(STDIN));

        if (!$passw) {
            echo "\n Действие прервано \n ";
            exit(1);
        }

        $model = new User();
        $model->username = 'admin';
        $model->email = Yii::$app->params['adminEmail'];
        $model->password = $passw;
        $model->role = User::ROLE_ADMIN;

        if ($model->save(false)) {
            echo "\n Пароль администратора изменен \n ";
            exit(0);
        }
        else {
            echo "\n Ошибка изменения пароля \n ";
            exit(1);
        }
    }

} 