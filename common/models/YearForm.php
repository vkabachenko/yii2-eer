<?php

namespace common\models;

use Yii;
use yii\base\Model;


class YearForm  extends Model
{
    public $year;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['year'], 'integer','min' => 2000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'year' => 'Год обучения',
        ];
    }

} 