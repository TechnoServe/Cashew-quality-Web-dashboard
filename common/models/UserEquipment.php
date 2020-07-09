<?php

namespace common\models;

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
 * @property User $user
 */
class UserEquipment extends \common\models\User
{
    /**
     * {@inheritdoc}
     */
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
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app','ID'),
            'id_user' => Yii::t('app', 'User'),
            'brand' => Yii::t('app', 'Brand'),
            'model' => Yii::t('app', 'Model'),
            'name' => Yii::t('app', 'Name'),
            'picture' => Yii::t('app', 'Picture'),
            'manufacturing_date' => Yii::t('app', 'Manufacturing Date'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }
}
