<?php

use yii\db\Migration;

/**
 * Class m200722_040724_alter_table_qar_detail
 */
class m200722_040724_alter_table_qar_detail extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("qar_detail", "value_with_shell", $this->string(255)->null()->after("value"));
        $this->addColumn("qar_detail", "value_without_shell", $this->string(255)->null()->after("value_with_shell"));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200722_040724_alter_table_qar_detail cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200722_040724_alter_table_qar_detail cannot be reverted.\n";

        return false;
    }
    */
}
