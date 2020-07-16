<?php


namespace backend\models;


use common\helpers\CashewAppHelper;
use Yii;
use yii\imagine\Image;

class Company extends \common\models\Company
{

    const STATUS_ACTIVE = 1;

    const STATUS_INACTIVE = 2;


    const STORAGE_DIRECTORY = "uploads/company/";


    public $logoUploaded;


    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            "logoUploaded" => Yii::t("app", "Upload logo"),
        ]);
    }


    public function rules()
    {
        return array_merge(parent::rules(), [
            [
                ['logoUploaded'],
                'file',
                'skipOnEmpty' => true,
                'extensions' => 'png, jpg, gif',
            ],
        ]);
    }

    public static function getStatusDropdownValues()
    {
        return [
            self::STATUS_ACTIVE => \Yii::t("app", "Active"),
            self::STATUS_INACTIVE => \Yii::t("app", "Inactive"),
        ];
    }

    /**
     * Upload file
     */
    public function uploadLogo()
    {

        $image = $this->logoUploaded;

        if ( ! empty($image)) { // if file passed is not an empty file

            if ($this->getOldAttribute("logo")) {
                $this->deleteAttachments();
            }

            //generate random file name
            $fileRandomBaseName = uniqid('company_logo_').'_'.date('Y_m_d-H_i_s',
                    time());

            // generate A unique filename
            $filename = $fileRandomBaseName.'.'.$image->extension;

            $thumb_filename = "thumb_".$fileRandomBaseName.'.'.$image->extension;

            // Create directory path for both image and thumbnail
            $path = self::STORAGE_DIRECTORY.$filename;
            $thumb_path = self::STORAGE_DIRECTORY.$thumb_filename;

            // Create directory if not exists
            CashewAppHelper::createFolderIfNotExist(self::STORAGE_DIRECTORY);

            try {
                $imageSaved = $image->saveAs($path);

                Image::thumbnail($path, 200, 200)
                    ->save($thumb_path, ['quality' => 80]);

                if ($imageSaved) {

                    $this->logo = $filename;

                    return true;

                } else {
                    return false;
                }
            } catch (\Exception $exception) {
                return false;
            }

        }

        if ( ! $this->isNewRecord && empty($image)) {
            $this->logo = $this->getOldAttribute("logo");
        }

        return true;
    }


    /**
     * Return image patch
     *
     * @return string
     */
    public function getLogoPath()
    {
        return ! empty($this->logo) ? Yii::getAlias("@web")."/".self::STORAGE_DIRECTORY.$this->logo : "";
    }


    /**
     * Return image patch
     *
     * @return string
     */
    public function getThumbLogoPath()
    {
        return ! empty($this->logo) ? Yii::getAlias("@web")."/".self::STORAGE_DIRECTORY."thumb_".$this->logo : "";
    }

    /**
     * Delete previous files
     */
    public function deleteAttachments()
    {
        if ( ! $this->isNewRecord && $this->logo) {
            try {
                unlink(getcwd().Yii::getAlias("@web")."/".self::STORAGE_DIRECTORY."thumb_".$this->logo);
                unlink(getcwd().Yii::getAlias("@web")."/".self::STORAGE_DIRECTORY.$this->logo);

            } catch (\Exception $e) {
                Yii::error("File does not exist");
            }
        }
    }


    /**
     * Site dropdown values for select2
     *
     * @param $attribute
     * @param $html_id
     * @param $placeholder
     *
     * @return array
     */
    public static function getCompaniesSelectWidgetValues($attribute, $html_id, $placeholder) {

        $companies = self::find()->where(["status"=>self::STATUS_ACTIVE])->all();

        $data = [];

        foreach ($companies as $company) {
            $data[$company->id] = $company->name;
        }

        return [
            'data' => $data,
            'attribute' => $attribute,
            'language' => Yii::$app->language,
            'options' => ['id' => $html_id, 'placeholder' => $placeholder],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ];
    }
}