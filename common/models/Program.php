<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "program".
 *
 * @property integer $id
 * @property integer $id_faculty
 * @property string $code
 * @property string $name
 * @property integer $level
 * @property integer $form
 * @property string $profile
 * @property string $standard
 * @property string $comment
 *
 * @property Discipline[] $disciplines
 * @property Faculty $idFaculty
 * @property ProgramFile[] $programFiles
 * @property StudentEducation[] $studentEducations
 */
class Program extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'program';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_faculty', 'code', 'name', 'level'], 'required'],
            [['id_faculty', 'level', 'form'], 'integer'],
            [['comment'], 'string'],
            [['code', 'standard'], 'string', 'max' => 50],
            [['name', 'profile'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'code' => 'Шифр',
            'name' => 'Наименование',
            'level' => 'Ступень высшего образования',
            'form' => 'Форма обучения',
            'profile' => 'Профиль',
            'standard' => 'Стандарт высшего образования',
            'comment' => 'Дополнительные характеристики',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
/*    public function getDisciplines()
    {
        return $this->hasMany(Discipline::className(), ['id_program' => 'id']);
    }
*/

    /**
     * @return \yii\db\ActiveQuery
     */
/*    public function getIdFaculty()
    {
        return $this->hasOne(Faculty::className(), ['id' => 'id_faculty']);
    }
*/
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramFiles()
    {
        return $this->hasMany(ProgramFile::className(), ['id_program' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::className(), ['id' => 'id_file'])
               ->via('programFiles');
    }


    /**
     * @return \yii\db\ActiveQuery
     */
      public function getProgramHeaders()
        {
            return $this->hasMany(ProgramHeader::className(), ['id_program' => 'id']);
        }



    /**
     * @return \yii\db\ActiveQuery
     */
/*    public function getStudentEducations()
    {
        return $this->hasMany(StudentEducation::className(), ['id_program' => 'id']);
    }
*/

}
