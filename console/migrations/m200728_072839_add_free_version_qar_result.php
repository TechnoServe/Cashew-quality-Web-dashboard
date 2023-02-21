<?php

use yii\db\Migration;

/**
 * Class m200728_072839_add_free_version_qar_result
 */
class m200728_072839_add_free_version_qar_result extends Migration
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

        $this->createTable('{{%free_qar_result}}', [
            'document_id' => $this->string()->notNull(),
            'qar' => $this->string(255)->null(),
            'kor' => $this->double()->null(),
            'defective_rate' => $this->double()->null(),
            'foreign_material_rate' => $this->double()->null(),
            'moisture_content' => $this->double()->null(),
            'nut_count' => $this->double()->null(),
            'useful_kernel' => $this->double()->null(),
            'total_volume_of_stock' => $this->double()->null(),
            'created_at' => $this->dateTime()->null(),
            'updated_at' => $this->dateTime()->null(),
        ], $tableOptions);

        $this->addPrimaryKey("free_qar_result_pk", "free_qar_result", "document_id");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200728_072839_add_free_version_qar_result cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200728_072839_add_free_version_qar_result cannot be reverted.\n";

        return false;
    }
    */
}
