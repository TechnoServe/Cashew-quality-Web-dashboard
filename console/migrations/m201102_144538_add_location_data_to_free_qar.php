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
        $this->addColumn("free_qar_result", "location_country", $this->string(128)->null()->after("location_lon"));
        $this->addColumn("free_qar_result", "location_country_code", $this->string(128)->null()->after("location_country"));
        $this->addColumn("free_qar_result", "location_city", $this->string(128)->null()->after("location_country_code"));
        $this->addColumn("free_qar_result", "location_region", $this->string(128)->null()->after("location_city"));
        $this->addColumn("free_qar_result", "location_sub_region", $this->string(128)->null()->after("location_region"));
        $this->addColumn("free_qar_result", "location_district", $this->string(128)->null()->after("location_sub_region"));
        $this->addColumn("free_qar_result", "location_street", $this->string(128)->null()->after("location_district"));
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
