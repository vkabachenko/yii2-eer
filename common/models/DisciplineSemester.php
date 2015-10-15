<?php

namespace common\models;

use Yii;
use backend\behaviors\CascadeBehavior;

/**
 * This is the model class for table "discipline_semester".
 *
 * @property integer $id
 * @property integer $id_discipline
 * @property integer $course
 * @property integer $semester
 * @property integer $max_rating
 *
 * @property Discipline $idDiscipline
 * @property StudentResult[] $studentResults
 */
class DisciplineSemester extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(),[
            [
                'class' => CascadeBehavior::className(),
                'children' => ['studentResults']
            ]
        ]);
    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'discipline_semester';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_discipline', 'semester', 'course'], 'required'],
            [['id_discipline', 'semester', 'max_rating','course'], 'integer'],
            [
                ['id_discipline', 'semester'],
                'unique',
                'targetAttribute' => ['id_discipline', 'semester'],
                'message' => 'Этот семестр уже введен'
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
            'id_discipline' => 'Id Discipline',
            'course' => 'Курс',
            'semester' => 'Семестр',
            'max_rating' => 'Макс. рейтинг',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdDiscipline()
    {
        return $this->hasOne(Discipline::className(), ['id' => 'id_discipline']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentResults()
    {
        return $this->hasMany(StudentResult::className(), ['id_discipline_semester' => 'id']);
    }


}
