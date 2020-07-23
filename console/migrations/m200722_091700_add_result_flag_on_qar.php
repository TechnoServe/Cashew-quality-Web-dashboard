<?php

use yii\db\Migration;

/**
 * Class m200722_091700_add_result_flag_on_qar
 */
class m200722_091700_add_result_flag_on_qar extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("qar_detail","result", $this->tinyInteger()->defaultValue(0)->after("value"));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200722_091700_add_result_flag_on_qar cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200722_091700_add_result_flag_on_qar cannot be reverted.\n";

        return false;
    }
    */
}
