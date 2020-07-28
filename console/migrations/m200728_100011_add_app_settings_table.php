<?php

use yii\db\Migration;

/**
 * Class m200728_100011_add_app_settings_table
 */
class m200728_100011_add_app_settings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Change table options for mysql driver
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%settings}}', [
            'key' => $this->string()->notNull(),
            'value' => $this->string(255)->null(),
        ], $tableOptions);

        $this->addPrimaryKey("settings_key_pk", "settings", "key");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200728_100011_add_app_settings_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200728_100011_add_app_settings_table cannot be reverted.\n";

        return false;
    }
    */
}
