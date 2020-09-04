<?php

use yii\db\Migration;

/**
 * Class m200904_072926_add_location_to_qar_tables
 */
class m200904_072926_add_location_to_qar_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("free_qar_result", "location_accuracy", $this->integer()->null()->after("total_volume_of_stock"));
        $this->addColumn("free_qar_result", "location_altitude", $this->integer()->null()->after("location_accuracy"));
        $this->addColumn("free_qar_result", "location_lat", $this->float()->null()->after("location_altitude"));
        $this->addColumn("free_qar_result", "location_lon", $this->float()->null()->after("location_lat"));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200904_072926_add_location_to_qar_tables cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200904_072926_add_location_to_qar_tables cannot be reverted.\n";

        return false;
    }
    */
}
