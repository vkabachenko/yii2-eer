<?php
namespace common\traits;

use yii\db\ActiveRecord;

trait AttributeTrait
{

      public function attributeValue(ActiveRecord $model, $fieldName) {

        $complexName = $model->tableName().'.'.$fieldName;

        $decode = \Yii::$app->params['decode'];
        $key = $model->$fieldName;

        if (isset($decode[$complexName]))
            return $decode[$complexName][$key];
        else
            return  $key;

    }



}