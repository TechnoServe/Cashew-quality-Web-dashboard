<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "free_sites".
 *
 * @property string $document_id
 * @property string|null $name
 * @property string|null $location
 * @property string|null $owner
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class FreeSites extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'free_sites';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['document_id'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['document_id', 'name', 'location', 'owner'], 'string', 'max' => 255],
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
            'name' => Yii::t('app', 'Name'),
            'location' => Yii::t('app', 'Location'),
            'owner' => Yii::t('app', 'Owner'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
