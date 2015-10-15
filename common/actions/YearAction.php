<?php

namespace common\actions;

use common\helpers\YearHelper;
use common\models\YearForm;
use Yii;
use yii\base\Action;

class YearAction  extends Action
{

    public function run() {

        $model = new YearForm();
        $model->year = YearHelper::getYear();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            YearHelper::setYear($model->year );
            $this->controller->goHome();
        }
        else {
            return $this->controller->renderAjax('@common/views/year.php',
                                        ['model' => $model]);
        }


    }

} 