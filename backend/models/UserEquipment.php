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

    const STORAGE_DIRECTORY = "uploads/";

    public $image;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(Parent::rules(), [
            [
                ['image'],
                'file',
                'skipOnEmpty' => true,
                'extensions' => 'png, jpg, gif',
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

            var_dump($thumb_path);

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
                var_dump($exception);
                die();
                // Could not create either the file or its thumbnail
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
        if(!$this->isNewRecord){
            unlink( getcwd(). Yii::getAlias("@web")."/".self::STORAGE_DIRECTORY."thumb_".$this->picture);
            unlink( getcwd(). Yii::getAlias("@web")."/".self::STORAGE_DIRECTORY.$this->picture);
        }
    }
}
