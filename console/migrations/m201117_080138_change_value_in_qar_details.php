<?php

use yii\db\Migration;

/**
 * Class m201117_080138_change_value_in_qar_details
 */
class m201117_080138_change_value_in_qar_details extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn("qar_detail", "value", $this->string(255)->defaultValue(null));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201117_080138_change_value_in_qar_details cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201117_080138_change_value_in_qar_details cannot be reverted.\n";

        return false;
    }
    */
}
