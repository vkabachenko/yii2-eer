<?php

namespace common\actions;

use Yii;
use yii\base\Action;
use common\models\LoginForm;

class LoginAction  extends Action
{

    public function run() {

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->login()) {
                    return $this->controller->goHome();
                }
            }
        }

        return $this->controller->render(
            '@common/views/login.php',
            [
                'model' => $model
            ]
        );


    }

} 