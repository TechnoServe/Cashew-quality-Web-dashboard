<?php

use yii\db\Migration;

/**
 * Class m200623_094914_create_qar_details
 */
class m200623_094914_create_qar_details extends Migration
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
        $this->createTable('qar_detail',[
            'id' => $this->primaryKey(),
            'id_qar' => $this->integer()->notNull(),
            'key' => $this->string(255)->notNull(),
            'value' => $this->text()->notNull(),
            'picture' => $this->string(255)->notNull(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP"),

        ], $tableOptions);

        $this->addForeignKey('fk_qar_details_qar_id','qar_detail','id_qar','qar','id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200623_094914_create_qar_details cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200623_094914_create_qar_details cannot be reverted.\n";

        return false;
    }
    */
}
