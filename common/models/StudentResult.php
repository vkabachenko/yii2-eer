<?php

namespace common\models;

use Yii;
use backend\behaviors\CascadeBehavior;

/**
 * This is the model class for table "student_result".
 *
 * @property integer $id
 * @property integer $id_student_education
 * @property integer $id_discipline_semester
 * @property string $passing_date
 * @property string $examiner
 * @property integer $rating
 * @property string $assesment
 *
 * @property StudentEducation $idStudentEducation
 * @property DisciplineSemester $idDisciplineSemester
 * @property StudentResultFile[] $studentResultFiles
 */
class StudentResult extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(),[
            [
                'class' => CascadeBehavior::className(),
                'children' => ['files']
            ]
        ]);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student_result';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_student_education', 'id_discipline_semester'], 'required'],
            [['id_student_education', 'id_discipline_semester', 'rating'], 'integer'],
            [['passing_date'], 'date', 'format' => 'dd-MM-yyyy'],
            [['examiner'], 'string', 'max' => 100],
            [['assesment'], 'string', 'max' => 10],
            [['id_student_education', 'id_discipline_semester'], 'unique', 'targetAttribute' => ['id_student_education', 'id_discipline_semester'], 'message' => 'The combination of Id Student Education and Id Discipline Semester has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_student_education' => 'Id Student Education',
            'id_discipline_semester' => 'Id Discipline Semester',
            'passing_date' => 'Дата сдачи',
            'examiner' => 'Экзаменатор',
            'rating' => 'Рейтинг',
            'assesment' => 'Оценка',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdStudentEducation()
    {
        return $this->hasOne(StudentEducation::className(), ['id' => 'id_student_education']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdDisciplineSemester()
    {
        return $this->hasOne(DisciplineSemester::className(), ['id' => 'id_discipline_semester']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentResultFiles()
    {
        return $this->hasMany(StudentResultFile::className(), ['id_student_result' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::className(), ['id' => 'id_file'])
            ->via('studentResultFiles');
    }

    public function beforeSave($insert) {

        if(parent::beforeSave($insert)) {
            $this->passing_date = static::convertDate($this->passing_date);
            return true;
        } else {
            return false;
        }
    }


    public function afterFind() {
        if ($this->passing_date) {
            $date = date('d-m-Y', strtotime($this->passing_date));
            $this->passing_date = $date;
        }
        parent::afterFind();
    }

    public static function convertDate($date) {

        return $date ? date('Y-m-d', strtotime($date)) : null;

    }


}
