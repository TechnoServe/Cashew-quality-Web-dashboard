<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "site".
 *
 * @property int $id
 * @property string $site_name
 * @property string $site_location
 * @property string $created_at
 * @property string $updated_at
 */
class Site extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'site';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['site_name', 'site_location', 'map_location', 'department_id'], 'required'],
            [['site_location'], 'string'],
            [['created_at', 'updated_at', 'company_id', 'department_id', 'map_location', 'image'], 'safe'],
            [['site_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'site_name' => Yii::t('app', 'Site Name'),
            'site_location' => Yii::t('app', 'Site Location'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'company_id' => Yii::t('app', 'Company'),
            'department_id' => Yii::t('app', 'Province'),
            'map_location' => Yii::t('app', 'Map Coordinates'),
            'average_kor' => Yii::t('app', 'Average KOR'),
        ];
    }
}
