<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "faculty".
 *
 * @property integer $id
 * @property string $name
 *
 * @property Program[] $programs
 * @property StudentEducation[] $studentEducations
 * @property User[] $users
 */
class Faculty extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'faculty';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Название',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    /*
    public function getPrograms()
    {
        return $this->hasMany(Program::className(), ['id_faculty' => 'id']);
    }
*/
    /**
     * @return \yii\db\ActiveQuery
     */
    /*
    public function getStudentEducations()
    {
        return $this->hasMany(StudentEducation::className(), ['id_faculty' => 'id']);
    }
*/
    /**
     * @return \yii\db\ActiveQuery
     */
    /*
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id_faculty' => 'id']);
    }
    */
}