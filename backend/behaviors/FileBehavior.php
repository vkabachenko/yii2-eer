<?php

namespace backend\behaviors;


use yii\base\Behavior;
use yii\web\UploadedFile;
use Yii;
use common\helpers\UploadHelper;
use yii\db\ActiveRecord;

class FileBehavior extends Behavior
{
    public $savedFile;
    public $deleteFlag = 0;

    public $originalNameAttr = 'document';
    public $realNameAttr = 'filename';
    public $savePath = '@frontend/web/files';


    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_DELETE => 'deleteFile',
            ActiveRecord::EVENT_BEFORE_INSERT => 'addFile',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'addFile'
        ];
    }


    public function nameFile()
    {
        return [
            'savedFile' => 'Загрузить файл',
            'deleteFlag' => 'Удалить файл'
        ];
    }

    public function ruleFile()
    {
        return [
            [['savedFile'],'safe'],
            [['savedFile'],'file',
                'extensions' => ['jpg', 'gif', 'png', 'pdf', 'txt',
                    'doc', 'docx', 'xls', 'xlsx', 'ppt',
                    'pptx', 'zip'],
                'maxSize' => UploadHelper::fileUploadMaxSize(),
            ],
            ['deleteFlag','boolean']
        ];
    }


    public function saveFile()
    {
        $file = UploadedFile::getInstance($this->owner, 'savedFile');
        if ($file && $file->size) {
            $this->deleteFile();
            $this->owner->{$this->originalNameAttr} = $file->name;

            $fileName = explode('.', $this->owner->{$this->originalNameAttr});
            $ext = end($fileName);

            $this->owner->{$this->realNameAttr} = Yii::$app->security->generateRandomString().".{$ext}";

            $path = Yii::getAlias($this->savePath).'/'.$this->owner->{$this->realNameAttr};
            $file->saveAs($path);
        }
    }

    public function deleteFile()
    {
        $path = Yii::getAlias($this->savePath).'/'.$this->owner->{$this->realNameAttr};
        if(is_file($path))
            unlink($path);
    }

    public function addFile()
    {
        if (!$this->deleteFlag)
            $this->saveFile();
        else {
            $this->deleteFile();
            $this->owner->{$this->originalNameAttr} = null;
            $this->owner->{$this->realNameAttr} = null;
        }
    }

} 