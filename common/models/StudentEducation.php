<?php

namespace common\models;

use Yii;
use backend\behaviors\CascadeBehavior;

/**
 * This is the model class for table "student_education".
 *
 * @property integer $id
 * @property integer $id_student
 * @property integer $year
 * @property integer $id_program
 * @property integer $course
 * @property string $group
 *
 * @property Student $idStudent
 * @property Program $idProgram
 * @property StudentResult[] $studentResults
 */
class StudentEducation extends \yii\db\ActiveRecord
{
    private $id_student_cached; // для удаления связанного студента


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
        return 'student_education';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_student', 'year', 'id_program'], 'required'],
            [['id_student', 'year', 'id_program'], 'integer'],
            [['course'], 'integer','min' => 1],
            ['course', 'default','value' => 1],
            [['group'], 'string', 'max' => 20],
            [['id_student','year'],'unique','targetAttribute' => ['id_student','year']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_student' => 'Студент',
            'year' => 'Год обучения',
            'id_program' => 'Образовательная программа',
            'course' => 'Курс',
            'group' => 'Группа',
            'studentName' => 'Фамилия ИО',
            'programName' => 'Образовательная программа',
            'idFaculty' => 'Факультет',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdStudent()
    {
        return $this->hasOne(Student::className(), ['id' => 'id_student']);
    }

    public function getStudentName()
    {
        return $this->idStudent->name;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProgram()
    {
        return $this->hasOne(Program::className(), ['id' => 'id_program']);
    }

    public function getProgramName()
    {
        return $this->idProgram->fullName;
    }

    public function getIdFaculty()
    {
        return $this->idProgram->id_faculty;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentResults()
    {
        return $this->hasMany(StudentResult::className(), ['id_student_education' => 'id']);
    }

    /**
     * @inheritdoc
     * Сохраняем id связанного студента для последующего его удаления
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            $this->id_student_cached = $this->id_student;
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * @inheritdoc
     * Удаляем связанную дисциплину, если не осталось для нее записи с именем
     */
    public function afterDelete()
    {
        if (!static::find()->
            where(['id_student' => $this->id_student_cached])->
            exists()) {
            Student::findOne($this->id_student_cached)->delete();
        }
    }


}
