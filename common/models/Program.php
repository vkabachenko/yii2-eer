<?php

namespace common\models;

use Yii;
use common\traits\ProgramTrait;
use backend\behaviors\CascadeBehavior;

/**
 * This is the model class for table "program".
 *
 * @property integer $id
 * @property integer $id_faculty
 * @property string $code
 * @property string $name
 * @property integer $level
 * @property integer $form
 * @property integer $duration
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

    use ProgramTrait;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(),[
            [
            'class' => CascadeBehavior::className(),
            'children' => ['disciplineNames','studentEducations','files']
                ]
        ]);
    }


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
    public function extraFields()
    {
        return ['fullName'];
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_faculty', 'code', 'name', 'level', 'duration'], 'required'],
            [['id_faculty', 'level', 'form'], 'integer'],
            [['comment'], 'string'],
            [['code', 'standard'], 'string', 'max' => 50],
            [['name', 'profile'], 'string', 'max' => 250],
            [['duration'], 'integer', 'min' => 1],
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
            'level' => 'Уровень высшего образования',
            'form' => 'Форма обучения',
            'profile' => 'Профиль',
            'standard' => 'Стандарт высшего образования',
            'comment' => 'Дополнительные характеристики',
            'duration' => 'Длительность обучения, лет'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisciplines()
    {
        return $this->hasMany(Discipline::className(), ['id_program' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisciplineNames()
    {
        return $this->hasMany(DisciplineName::className(), ['id_program_main' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdFaculty()
    {
        return $this->hasOne(Faculty::className(), ['id' => 'id_faculty']);
    }

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
    public function getStudentEducations()
    {
        return $this->hasMany(StudentEducation::className(), ['id_program' => 'id']);
    }


    public function getFullName()
    {
        $attributes = $this->defaultAttributes;
        $additiveHeaders = $this->programHeaders;
        foreach($additiveHeaders as $header) {
            $attributes[] = $header->field_shown;
        }

        return $this->concatAttributes($attributes);
    }

}
