<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%qar}}`.
 */
class m200623_094019_create_qar_table extends Migration
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

        // Create table statement
        // All columns are required
        $this->createTable('qar',[
            'id' => $this->primaryKey(),
            'buyer' => $this->integer()->null(),
            'field_tech' => $this->integer()->null(),
            'farmer' => $this->integer()->null(),
            'initiator' => $this->integer()->notNull(),
            'site' => $this->integer()->notNull(),
            'audit_quantity' => $this->string(255)->null(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP"),
        ], $tableOptions);

        $this->addForeignKey('fk_qar-buyer','qar','buyer','user','id');
        $this->addForeignKey('fk_qar-field_tech','qar','field_tech','user','id');
        $this->addForeignKey('fk_qar-farmer','qar','farmer','user','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%qar}}');
    }
}
