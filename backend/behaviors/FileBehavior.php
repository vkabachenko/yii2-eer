<?php

namespace backend\behaviors;


use yii\base\Behavior;
use yii\web\UploadedFile;
use Yii;
use common\helpers\UploadHelper;

class FileBehavior extends Behavior
{
    public $savedFile;

    public $originalNameAttr = 'document';
    public $realNameAttr = 'filename';
    public $savePath = '@frontend/web/files';

    public function nameFile()
    {
        return [
            'savedFile' => 'Загрузить файл'
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
            ]
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

} 