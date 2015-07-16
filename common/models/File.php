<?php

namespace common\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "file".
 *
 * @property integer $id
 * @property string $title
 * @property string $document
 * @property string $filename
 * @property integer $role
 *
 * @property DisciplineFile[] $disciplineFiles
 * @property ProgramFile[] $programFiles
 * @property StudentPortfolio[] $studentPortfolios
 * @property StudentResultFile[] $studentResultFiles
 */
class File extends \yii\db\ActiveRecord
{
    public $savedFile; // сохраняемый файл при загрузке

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['role'], 'integer'],
            [['title'], 'string', 'max' => 250],
            [['savedFile'],'safe'],
            [['savedFile'],'file',
             'extensions' => ['jpg', 'gif', 'png', 'pdf', 'txt',
                              'doc', 'docx', 'xls', 'xlsx', 'ppt',
                              'pptx', 'zip'],
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Описание',
            'document' => 'Оригинальное имя',
            'filename' => 'Системное имя',
            'role' => 'Роль',
            'savedFile' => 'Загрузить файл'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisciplineFiles()
    {
        return $this->hasMany(DisciplineFile::className(), ['id_file' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramFiles()
    {
        return $this->hasMany(ProgramFile::className(), ['id_file' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
   public function getStudentPortfolios()
    {
        return $this->hasMany(StudentPortfolio::className(), ['id_file' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentResultFiles()
    {
        return $this->hasMany(StudentResultFile::className(), ['id_file' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $file = UploadedFile::getInstance($this, 'savedFile');
            if ($file) {
                $this->deleteFile();
                $this->document = $file->name;

                $fileName = explode('.', $this->document);
                $ext = end($fileName);

                $this->filename = Yii::$app->security->generateRandomString().".{$ext}";

                $this->title = $this->title ?: $this->document;
                $path = Yii::getAlias('@frontend/web/files').'/'.$this->filename;
                $file->saveAs($path);
            }

            return $this->filename ? true : false;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if(!parent::beforeDelete())
            return false;
        $this->deleteFile(); // удалили модель? удаляем и файл
        return true;
    }


    private function deleteFile()
    {
        $path = Yii::getAlias('@frontend/web/files').'/'.$this->filename;
        if(is_file($path))
            unlink($path);

    }

}
