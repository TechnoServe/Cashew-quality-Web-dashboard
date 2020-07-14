<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "company".
 *
 * @property int $id
 * @property string $name
 * @property string $city
 * @property string $address
 * @property string $primary_contact
 * @property string $primary_phone
 * @property string $primary_email
 * @property string|null $fax_number
 * @property integer $status
 * @property string|null $logo
 * @property string|null $description
 * @property string $created_at
 * @property string $updated_at
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'city', 'address', 'primary_contact', 'primary_phone', 'primary_email', 'status'], 'required'],
            [['status'], 'integer'],
            [['primary_email'], 'email'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'city', 'address', 'primary_contact', 'primary_phone', 'primary_email', 'fax_number', 'logo', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'city' => Yii::t('app', 'City'),
            'address' => Yii::t('app', 'Address'),
            'primary_contact' => Yii::t('app', 'Primary Contact'),
            'primary_phone' => Yii::t('app', 'Primary Phone'),
            'primary_email' => Yii::t('app', 'Primary Email'),
            'fax_number' => Yii::t('app', 'Fax Number'),
            'status' => Yii::t('app', 'Status'),
            'logo' => Yii::t('app', 'Logo'),
            'description' => Yii::t('app', 'Description'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
