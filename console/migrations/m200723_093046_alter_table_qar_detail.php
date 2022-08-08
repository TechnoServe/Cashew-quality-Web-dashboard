<?php

use yii\db\Migration;

/**
 * Class m200723_093046_alter_table_qar_detail
 */
class m200723_093046_alter_table_qar_detail extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn("qar_detail", "picture", $this->string(255)->null());
        $this->alterColumn("qar_detail", "value", $this->float()->null());
        $this->alterColumn("qar_detail", "value_with_shell", $this->float()->null());
        $this->alterColumn("qar_detail", "value_without_shell", $this->float()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200723_093046_alter_table_qar_detail cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200723_093046_alter_table_qar_detail cannot be reverted.\n";

        return false;
    }
    */
}
