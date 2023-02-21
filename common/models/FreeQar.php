<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "free_qar".
 *
 * @property string $document_id
 * @property string|null $field_tech
 * @property string|null $buyer
 * @property string|null $site
 * @property int|null $status
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class FreeQar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'free_qar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['document_id'], 'required'],
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['document_id', 'field_tech', 'buyer', 'site'], 'string', 'max' => 255],
            [['document_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'document_id' => Yii::t('app', 'Document ID'),
            'field_tech' => Yii::t('app', 'Field Tech'),
            'buyer' => Yii::t('app', 'Buyer'),
            'site' => Yii::t('app', 'Site'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
