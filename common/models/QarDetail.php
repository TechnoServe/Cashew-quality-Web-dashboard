<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "qar_detail".
 *
 * @property int $id
 * @property int $id_qar
 * @property string $key
 * @property string $value
 * @property string|null $value_with_shell
 * @property string|null $value_without_shell
 * @property string $picture
 * @property int|null $sample_number
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Qar $qar
 */
class QarDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'qar_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_qar', 'key', 'value', 'picture'], 'required'],
            [['id_qar', 'sample_number'], 'integer'],
            [['value'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['key', 'value_with_shell', 'value_without_shell', 'picture'], 'string', 'max' => 255],
            [['id_qar'], 'exist', 'skipOnError' => true, 'targetClass' => Qar::className(), 'targetAttribute' => ['id_qar' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_qar' => Yii::t('app', 'Id Qar'),
            'key' => Yii::t('app', 'Key'),
            'value' => Yii::t('app', 'Value'),
            'value_with_shell' => Yii::t('app', 'Value With Shell'),
            'value_without_shell' => Yii::t('app', 'Value Without Shell'),
            'picture' => Yii::t('app', 'Picture'),
            'sample_number' => Yii::t('app', 'Sample Number'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Qar]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQar()
    {
        return $this->hasOne(Qar::className(), ['id' => 'id_qar']);
    }
}
