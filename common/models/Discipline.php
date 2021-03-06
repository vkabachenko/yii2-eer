<?php

namespace common\models;

use Yii;
use backend\behaviors\CascadeBehavior;

/**
 * This is the model class for table "discipline".
 *
 * @property integer $id
 * @property integer $id_program
 * @property string $code_first
 * @property string $code_last
 * @property integer $kind
 * @property integer $block
 *
 * @property Program $idProgram
 * @property DisciplineName[] $disciplineNames
 * @property DisciplineSemester[] $disciplineSemesters
 */
class Discipline extends \yii\db\ActiveRecord
{
    /* см. common/config/params.php
       decode  discipline.block номер ДПВ = 2
    */
    const DISCIPLINE_CHOICE = 2;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(),[
            [
                'class' => CascadeBehavior::className(),
                'children' => ['disciplineSemesters']
            ]
        ]);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'discipline';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_program', 'code_first', 'kind'], 'required'],
            [['id_program', 'kind', 'block'], 'integer'],
            [['code_first','code_last'], 'string', 'max' => 20],
            [
                ['id_program', 'code_first','code_last'],
                'unique',
                'targetAttribute' => ['id_program', 'code_first','code_last'],
                'message' => 'Эта комбинация буквенного и числового шифров уже используется'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_program' => 'Id Program',
            'code_first' => 'Буквенная часть шифра, например, Б1.В.ОД',
            'code_last' => 'Числовая часть шифра, например, 10.1',
            'kind' => 'Вид',
            'block' => 'Блок',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProgram()
    {
        return $this->hasOne(Program::className(), ['id' => 'id_program']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisciplineNames()
    {
        return $this->hasMany(DisciplineName::className(), ['id_discipline' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisciplineSemesters()
    {
        return $this->hasMany(DisciplineSemester::className(), ['id_discipline' => 'id']);
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code_first.($this->code_last ? '.'.$this->code_last : '');
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        if ($this->block == self::DISCIPLINE_CHOICE) {
            return "$this->code Дисциплина по выбору";
        }
        else {
            /* @var $disciplineName DisciplineName */
            $disciplineName = DisciplineName::findOne(['id_discipline' => $this->id]);
            return $disciplineName ? "$this->code $disciplineName->name" : 'Not found';
        }

    }


}
