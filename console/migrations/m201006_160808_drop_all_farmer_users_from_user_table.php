<?php

use common\models\User;
use yii\db\Migration;

/**
 * Handles the dropping of table `{{%all_farmer_users_from_user}}`.
 */
class m201006_160808_drop_all_farmer_users_from_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       User::deleteAll(['role' => 7]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->createTable('{{%all_farmer_users_from_user}}', [
            'id' => $this->primaryKey(),
        ]);
    }
}
