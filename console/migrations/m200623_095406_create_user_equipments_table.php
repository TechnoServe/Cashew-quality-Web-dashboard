<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_equipments}}`.
 */
class m200623_095406_create_user_equipments_table extends Migration
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
        $this->createTable('user_equipment',[
            'id' => $this->primaryKey(),
            'id_user' => $this->integer()->notNull(),
            'brand' => $this->string(255)->notNull(),
            'model' => $this->string(255)->null(),
            'name' => $this->string(255)->notNull(),
            'picture' => $this->string(255)->notNull(),
            'manufacturing_date' => $this->date()->null(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP"),

        ], $tableOptions);

        $this->addForeignKey('fk_user_equipments_user_id','user_equipment','id_user','user','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_equipments}}');
    }
}
