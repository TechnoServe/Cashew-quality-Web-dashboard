<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user_equipment".
 *
 * @property int $id
 * @property int $id_user
 * @property string $brand
 * @property string|null $model
 * @property string $name
 * @property string $picture
 * @property string|null $manufacturing_date
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $user0
 */
class UserEquipment extends \common\models\UserEquipment
{
    /**
     * {@inheritdoc}
     */

    public $image;
     
    public static function tableName()
    {
        return 'user_equipment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user', 'brand', 'name', 'picture'], 'required'],
            [['id_user'], 'integer'],
            [['manufacturing_date', 'created_at', 'updated_at'], 'safe'],
            [['brand', 'model', 'name', 'picture'], 'string', 'max' => 255],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
            [['image'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, gif'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_user' => Yii::t('app', 'User'),
            'brand' => Yii::t('app', 'Brand'),
            'model' => Yii::t('app', 'Model'),
            'name' => Yii::t('app', 'Name'),
            'image' => Yii::t('app', 'Image'),
            'manufacturing_date' => Yii::t('app', 'Manufacturing Date'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[User0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser0()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    /**
     * Get User Full Name
     */

    public function getUserFullName()
    {
        $user = User::findOne($this->id_user);
        if (empty($user->middle_name)) {
            return $user->first_name . ' ' . $user->last_name;
        } else {
            return $user->first_name . ' ' . $user->middle_name . ' ' . $user->last_name;
        }
    }

    /**
     * Upload file
     */
    public function upload()
    {
        if ($this->validate()) {
            $this->image->saveAs('uploads/' . $this->image->baseName . '.' . $this->image->extension);
            return true;
        } else {
            return false;
        }
    }
}
