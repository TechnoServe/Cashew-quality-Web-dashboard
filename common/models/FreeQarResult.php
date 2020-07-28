<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "free_qar_result".
 *
 * @property string $document_id
 * @property string|null $qar
 * @property float|null $kor
 * @property float|null $defective_rate
 * @property float|null $foreign_material_rate
 * @property float|null $moisture_content
 * @property float|null $nut_count
 * @property float|null $useful_kernel
 * @property float|null $total_volume_of_stock
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class FreeQarResult extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'free_qar_result';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['document_id'], 'required'],
            [['kor', 'defective_rate', 'foreign_material_rate', 'moisture_content', 'nut_count', 'useful_kernel', 'total_volume_of_stock'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['document_id', 'qar'], 'string', 'max' => 255],
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
            'qar' => Yii::t('app', 'Qar'),
            'kor' => Yii::t('app', 'Kor'),
            'defective_rate' => Yii::t('app', 'Defective Rate'),
            'foreign_material_rate' => Yii::t('app', 'Foreign Material Rate'),
            'moisture_content' => Yii::t('app', 'Moisture Content'),
            'nut_count' => Yii::t('app', 'Nut Count'),
            'useful_kernel' => Yii::t('app', 'Useful Kernel'),
            'total_volume_of_stock' => Yii::t('app', 'Total Volume Of Stock'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
