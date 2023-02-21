<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%user}}`.
 */
class m200623_091300_add_columns_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("user", "role", $this->integer()->after("created_at")->notNull());
        $this->addColumn("user", "phone", $this->string(64)->after("email")->null());
        $this->addColumn("user", "address", $this->string(255)->after("phone")->null());
        $this->addColumn("user", "language", $this->string(64)->after("address")->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
