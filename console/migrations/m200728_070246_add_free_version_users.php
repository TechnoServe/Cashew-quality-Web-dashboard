<?php

use yii\db\Migration;

/**
 * Class m200728_070246_add_free_version_users
 */
class m200728_070246_add_free_version_users extends Migration
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

        $this->createTable('{{%free_users}}', [
            'document_id' => $this->string()->notNull(),
            'user_type' => $this->integer()->null(),
            'names' => $this->string(255)->null(),
            'email' => $this->string(255)->null(),
            'telephone' => $this->string(255)->null(),
            'created_at' => $this->dateTime()->null(),
            'updated_at' => $this->dateTime()->null(),
        ], $tableOptions);

        $this->addPrimaryKey("fre_users_pk", "free_users", "document_id");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200728_070246_add_free_version_users cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200728_070246_add_free_version_users cannot be reverted.\n";

        return false;
    }
    */
}
