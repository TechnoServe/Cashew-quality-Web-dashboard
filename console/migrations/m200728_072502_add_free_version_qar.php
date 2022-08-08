<?php

use yii\db\Migration;

/**
 * Class m200728_072502_add_free_version_qar
 */
class m200728_072502_add_free_version_qar extends Migration
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

        $this->createTable('{{%free_qar}}', [
            'document_id' => $this->string()->notNull(),
            'field_tech' => $this->string(255)->null(),
            'buyer' => $this->string(255)->null(),
            'site' => $this->string(255)->null(),
            'status' => $this->integer()->null(),
            'created_at' => $this->dateTime()->null(),
            'updated_at' => $this->dateTime()->null(),
        ], $tableOptions);

        $this->addPrimaryKey("free_qar_pk", "free_qar", "document_id");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200728_072502_add_free_version_qar cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200728_072502_add_free_version_qar cannot be reverted.\n";

        return false;
    }
    */
}
