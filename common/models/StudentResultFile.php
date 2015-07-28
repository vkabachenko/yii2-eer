<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "student_result_file".
 *
 * @property integer $id
 * @property integer $id_student_result
 * @property integer $id_file
 *
 * @property StudentResult $idStudentResult
 * @property File $idFile
 */
class StudentResultFile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student_result_file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_student_result', 'id_file'], 'required'],
            [['id', 'id_student_result', 'id_file'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_student_result' => 'Id Student Result',
            'id_file' => 'Id File',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdStudentResult()
    {
        return $this->hasOne(StudentResult::className(), ['id' => 'id_student_result']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdFile()
    {
        return $this->hasOne(File::className(), ['id' => 'id_file']);
    }
}
