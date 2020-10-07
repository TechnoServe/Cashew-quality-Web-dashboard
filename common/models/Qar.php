<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "qar".
 *
 * @property int $id
 * @property int|null $buyer
 * @property int|null $field_tech
 * @property int $initiator
 * @property int $site
* @property int $status
 * @property string|null $audit_quantity
 * @property string $created_at
 * @property string $updated_at
 * @property string $reminder1
 * @property string $reminder2
 *
 * @property User $buyer0
 * @property User $fieldTech
 * @property string $deadline
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
            [['buyer', 'field_tech', 'initiator', 'site', 'status'], 'integer'],
            [['number_of_bags','volume_of_stock'], 'number'],
            [['initiator', 'site', 'buyer', 'field_tech', 'number_of_bags', 'volume_of_stock'], 'required'],
            [['created_at', 'updated_at', 'company_id', 'deadline', 'status', 'number_of_bags', 'reminder1', 'reminder2'], 'safe'],
            [['buyer'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['buyer' => 'id']],
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
            'initiator' => Yii::t('app', 'Initiator'),
            'site' => Yii::t('app', 'Site'),
            'volume_of_stock' => Yii::t('app', 'Estimated Volume of Stock (KG)'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'company_id' => Yii::t('app', 'Company'),
            'deadline' => Yii::t('app', 'Deadline'),
            'number_of_bags' => Yii::t('app', 'Estimated number of bags'),
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
