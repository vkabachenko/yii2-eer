<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use backend\behaviors\CascadeBehavior;
use backend\behaviors\FileBehavior;

/**
 * This is the model class for table "faculty".
 *
 * @property integer $id
 * @property string $name
 * @property string $image
 * @property string $filename
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
    public function behaviors()
    {
        return array_merge(parent::behaviors(),[
            [
            'class' => CascadeBehavior::className(),
            'children' => ['programs']
                ],
            [
                'class' => FileBehavior::className(),
                'originalNameAttr' => 'image',
            ]
        ]);
    }

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
        return array_merge($this->ruleFile(),[
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100]
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'savedFile' => 'Загрузить файл эмблемы',
            'deleteFlag' => 'Удалить файл эмблемы'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getPrograms()
    {
        return $this->hasMany(Program::className(), ['id_faculty' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getStudentEducations()
    {
        return $this->hasMany(StudentEducation::className(), ['id_faculty' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id_faculty' => 'id']);
    }

    public static function getFacultyList()
    {

        $faculties = static::find()->orderBy('name')->all();
        return ArrayHelper::map($faculties,'id','name');
    }

}
