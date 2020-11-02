<?php

use yii\db\Migration;

/**
 * Class m201102_144538_add_location_data_to_free_qar
 */
class m201102_144538_add_location_data_to_free_qar extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201102_144538_add_location_data_to_free_qar cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201102_144538_add_location_data_to_free_qar cannot be reverted.\n";

        return false;
    }
    */
}
