<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "free_users".
 *
 * @property string $document_id
 * @property int|null $user_type
 * @property string $names
 * @property string $email
 * @property string $telephone
 * @property string $created_at
 * @property string $updated_at
 */
class FreeUsers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'free_users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['document_id'], 'required'],
            [['user_type'], 'integer'],
            [['created_at', 'updated_at', 'names', 'email', 'telephone', 'created_at'], 'safe'],
            [['document_id', 'names', 'email', 'telephone'], 'string', 'max' => 255],
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
            'user_type' => Yii::t('app', 'User Type'),
            'names' => Yii::t('app', 'Names'),
            'email' => Yii::t('app', 'Email'),
            'telephone' => Yii::t('app', 'Telephone'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
