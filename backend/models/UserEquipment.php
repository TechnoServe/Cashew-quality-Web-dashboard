<?php

namespace backend\models;

use common\helpers\CashewAppHelper;
use Yii;
use yii\imagine\Image;


class UserEquipment extends \common\models\UserEquipment
{

    /**
     * {@inheritdoc}
     */

    const STORAGE_DIRECTORY = "uploads/equipments/";

    public $image;
    /**
     * Query users by company
     * @return \yii\db\ActiveQuery
     */
    public static function queryByCompany($loggedInUser = null){

        if(!$loggedInUser)
            $loggedInUser = Yii::$app->user->identity;
        if($loggedInUser->role != User::ROLE_ADMIN && $loggedInUser->role != User::ROLE_ADMIN_VIEW) {

            if($loggedInUser->role == User::ROLE_FIELD_TECH)
                return self::find()->where(["company_id" => $loggedInUser->company_id])->andWhere(["id_user"=>$loggedInUser->id]);

            return self::find()->where(["company_id" => $loggedInUser->company_id]);
        }

        return self::find();
    }



    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(Parent::rules(), [
            [
                ['image'],
                'file',
                'skipOnEmpty' => !$this->isNewRecord,
                'extensions' => 'png, jpg, gif',
            ],

            [
                'model',
                function ($attribute, $params) {

                    $q = self::queryByCompany()->andWhere(["model" => trim($this->model)]);
                    if (!$this->isNewRecord)
                        $q->andWhere(["<>", "id", $this->id]);

                    $q->andWhere(['id_user' => $this->id_user]);

                    if ($q->exists())
                        $this->addError($attribute, Yii::t("app", "FieldTech already has this model registered"));

                    return false;
                },
                'skipOnEmpty' => false, 'skipOnError' => false
            ],

            [
                'name',
                function ($attribute, $params) {

                    $q = self::queryByCompany()->andWhere(["name" => trim($this->name)]);
                    if (!$this->isNewRecord)
                        $q->andWhere(["<>", "id", $this->id]);

                    $q->andWhere(['id_user' => $this->id_user]);

                    if ($q->exists())
                        $this->addError($attribute, Yii::t("app", "FieldTech already has this name registered"));
                    return false;
                },
                'skipOnEmpty' => false, 'skipOnError' => false
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(Parent::attributeLabels(), [
            'image' => Yii::t('app', 'Image'),
        ]);
    }

    /**
     * Get User Full Name
     */

    public function getUserFullName()
    {
        $user = User::findOne($this->id_user);
        if (empty($user->middle_name)) {
            return $user->first_name.' '.$user->last_name;
        } else {
            return $user->first_name.' '.$user->middle_name.' '.$user->last_name;
        }
    }

    /**
     * Upload file
     */
    public function uploadImage()
    {

        $image = $this->image;

        if ( ! empty($this->image)) { // if file passed is not an empty file

            $this->deleteAttachments();


            //generate random file name
            $fileRandomBaseName = uniqid('equipment_').'_'.date('Y_m_d-H_i_s', time());

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
                Image::thumbnail($path, 200, 200)->save($thumb_path, ['quality' => 80]);

                if ($imageSaved) {

                    $this->picture = $filename;

                    return true;

                } else {
                    return false;
                }
            } catch (\Exception $exception) {
                return false;
            }

        }

        if (!$this->isNewRecord && empty($image)) {
            $this->picture = $this->getOldAttribute("picture");
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
        return ! empty($this->picture) ? Yii::getAlias("@web")."/".self::STORAGE_DIRECTORY.$this->picture : "";
    }


    /**
     * Return image patch
     *
     * @return string
     */
    public function getThumbImagePath()
    {
        return ! empty($this->picture) ? Yii::getAlias("@web")."/".self::STORAGE_DIRECTORY."thumb_".$this->picture : "";
    }

    /**
     * Delete previous files
     */
    public function deleteAttachments(){
        if(!$this->isNewRecord && $this->picture){
            try {
                unlink(getcwd().Yii::getAlias("@web")."/".self::STORAGE_DIRECTORY."thumb_".$this->picture);
                unlink(getcwd().Yii::getAlias("@web")."/".self::STORAGE_DIRECTORY.$this->picture);
            } catch (\Exception $e){
                Yii::error("File does not exist");
            }
        }
    }

    /**
     * Clean input data to ensure data validation
     */
    public function purifyInput(){
        $loggedInUser = Yii::$app->user->identity;


        // If user is not an institution admin
        if ($loggedInUser->role != User::ROLE_ADMIN && $loggedInUser->role != User::ROLE_ADMIN_VIEW) {
            if ($loggedInUser->role == User::ROLE_FIELD_TECH) {
                $this->id_user = $loggedInUser->id;
            }
        }

        //Set company id
        $this->company_id = $loggedInUser->company_id;
    }
}
