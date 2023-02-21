<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%company}}`.
 */
class m200714_074555_create_company_table extends Migration
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

        $this->createTable('{{%company}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'city' => $this->string(255)->notNull(),
            'address' => $this->string(255)->notNull(),
            'primary_contact' => $this->string(255)->notNull(),
            'primary_phone' => $this->string(255)->notNull(),
            'primary_email' => $this->string(255)->notNull(),
            'fax_number' => $this->string(255)->null(),
            'status' => $this->integer()->notNull(),
            'logo' => $this->string(255)->null(),
            'description' => $this->text()->null(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP"),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%company}}');
    }
}
