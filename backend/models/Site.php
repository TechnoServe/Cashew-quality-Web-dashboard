<?php


namespace backend\models;

use common\helpers\CashewAppHelper;
use common\models\Site as baseSite;
use Yii;
use yii\imagine\Image;


class Site extends baseSite
{

    public $siteImage;

    public $latitude;
    public $longitude;

    const STORAGE_DIRECTORY = "uploads/site/";

    public function rules()
    {
        return array_merge(parent::rules(), [
            [
                ['siteImage'],
                'file',
                'skipOnEmpty' => !$this->isNewRecord,
                'extensions' => 'png, jpg, gif',
            ],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            "siteImage" => Yii::t("app", "Image of the site"),
        ]);
    }

    /**
     * Query users by company
     * @return \yii\db\ActiveQuery
     */
    public static function queryByCompany($loggedInUser = null){

        if(!$loggedInUser)
            $loggedInUser = Yii::$app->user->identity;

        if($loggedInUser->role != User::ROLE_ADMIN && $loggedInUser->role != User::ROLE_ADMIN_VIEW)
            return self::find()->where(["company_id" =>  $loggedInUser->company_id]);
        return self::find();
    }


    /**
     * Site dropdown values for select2
     * @param $attribute
     * @param $html_id
     * @param $placeholder
     *
     * @return array
     */
    public static function getSiteSelectWidgetValues($attribute , $html_id, $placeholder)
    {
       $allSites = self::queryByCompany()->all();

        $data = [];

        foreach ($allSites as $site){
            $data[$site->id] = $site->site_name. " " . $site->site_location;
        }

        return [
            'data' => $data,
            'attribute' => $attribute,
            'language' => Yii::$app->language,
            'options' => ['id' => $html_id, 'placeholder' => $placeholder],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ];
    }

    /**
     * Clean input data to ensure data validation
     */
    public function purifyInput(){
        $loggedInUser = Yii::$app->user->identity;

        //Set company id
        $this->company_id = $loggedInUser->company_id;
    }



    /**
     * Upload file
     */
    public function uploadImage()
    {

        $image = $this->siteImage;

        if ( ! empty($image)) { // if file passed is not an empty file

            if ($this->getOldAttribute("image")) {
                $this->deleteAttachments();
            }

            //generate random file name
            $fileRandomBaseName = uniqid('site_image_').'_'.date('Y_m_d-H_i_s', time());

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

                    $this->image = $filename;

                    return true;

                } else {
                    return false;
                }
            } catch (\Exception $exception) {
                return false;
            }

        }

        if ( ! $this->isNewRecord && empty($image)) {
            $this->image = $this->getOldAttribute("image");
        }

        return true;
    }


    /**
     * Return image patch
     *
     * @return string
     */
    public function getImagePath()
    {
        return ! empty($this->image) ? Yii::getAlias("@web")."/".self::STORAGE_DIRECTORY.$this->image : "";
    }


    /**
     * Return image patch
     *
     * @return string
     */
    public function getThumbImagePath()
    {
        return ! empty($this->image) ? Yii::getAlias("@web")."/".self::STORAGE_DIRECTORY."thumb_".$this->image : "";
    }

    /**
     * Delete previous files
     */
    public function deleteAttachments()
    {
        if ( ! $this->isNewRecord && $this->image) {
            try {
                unlink(getcwd().Yii::getAlias("@web")."/".self::STORAGE_DIRECTORY."thumb_".$this->image);
                unlink(getcwd().Yii::getAlias("@web")."/".self::STORAGE_DIRECTORY.$this->image);
            } catch (\Exception $e){
                Yii::error("File does not exist");
            }
        }
    }

    /**
     * Get latitude and longitude from map location
     */
    public function getLatitudeAndLongitudeFromMapLocation(){
        if(!empty($this->map_location))
            list($this->latitude, $this->longitude) = explode(",", $this->map_location);
    }
}