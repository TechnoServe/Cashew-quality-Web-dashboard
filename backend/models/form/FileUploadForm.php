<?php


namespace backend\models\form;

use yii\base\Model;

class FileUploadForm extends Model
{
    public $language;
    public $file;

    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'pdf'],
            ['language', 'required']
        ];
    }

    public function upload($language, $fileType = "terms_and_conditions")
    {
        if ($this->file) {
            $this->file->saveAs('uploads/cnqa_'.$fileType.'_'.$language.'.pdf');
            return true;
        } else {
            return false;
        }
    }
}