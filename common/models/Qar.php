<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "qar".
 *
 * @property int $id
 * @property int|null $buyer
 * @property int|null $field_tech
 * @property int|null $farmer
 * @property int $initiator
 * @property int $site
 * @property string|null $audit_quantity
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $buyer0
 * @property User $farmer0
 * @property User $fieldTech
 * @property QarDetail[] $qarDetails
 */
class Qar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'qar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['buyer', 'field_tech', 'farmer', 'initiator', 'site'], 'integer'],
            [['initiator', 'site', 'buyer', 'field_tech'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['audit_quantity'], 'string', 'max' => 255],
            [['buyer'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['buyer' => 'id']],
            [['farmer'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['farmer' => 'id']],
            [['field_tech'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['field_tech' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'buyer' => Yii::t('app', 'Buyer'),
            'field_tech' => Yii::t('app', 'Field Tech'),
            'farmer' => Yii::t('app', 'Farmer'),
            'initiator' => Yii::t('app', 'Initiator'),
            'site' => Yii::t('app', 'Site'),
            'audit_quantity' => Yii::t('app', 'Audit Quantity'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Buyer0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBuyer0()
    {
        return $this->hasOne(User::className(), ['id' => 'buyer']);
    }

    /**
     * Gets query for [[Farmer0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFarmer0()
    {
        return $this->hasOne(User::className(), ['id' => 'farmer']);
    }

    /**
     * Gets query for [[FieldTech]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFieldTech()
    {
        return $this->hasOne(User::className(), ['id' => 'field_tech']);
    }

    /**
     * Gets query for [[QarDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQarDetails()
    {
        return $this->hasMany(QarDetail::className(), ['id_qar' => 'id']);
    }
}
