<?php

namespace common\actions;

use common\helpers\YearHelper;
use common\models\YearForm;
use Yii;
use yii\base\Action;

class YearAction  extends Action
{

    public function run($to=null) {

        if ($to) {
            $this->newYear($to);
        }
        else {
            $model = new YearForm();
            $model->year = YearHelper::getYear();
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $this->newYear($model->year);
            }
            else {
                return $this->controller->renderAjax('@common/views/year.php',
                    ['model' => $model]);
            }
        }
    }

    private function newYear($year)
    {
        YearHelper::setYear($year);
        $this->controller->redirect(Yii::$app->request->referrer);
    }

} 