<?php
namespace common\traits;


trait AttributeTrait
{

      public function attributeValue($fieldName) {

        $complexName = $this->tableName().'.'.$fieldName;

        $decode = \Yii::$app->params['decode'];
        $key = $this->$fieldName;

        if ($key !== null && isset($decode[$complexName]))
            return $decode[$complexName][$key];
        else
            return  $key;

    }



}