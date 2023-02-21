<?php

use yii\db\Migration;

/**
 * Class m200720_113316_split_audit_quantity
 */
class m200720_113316_split_audit_quantity extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn("qar", "audit_quantity", "number_of_bags");
        $this->alterColumn("qar", "number_of_bags", $this->float()->null());
        $this->addColumn("qar", "volume_of_stock", $this->float()->null()->after("number_of_bags"));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200720_113316_split_audit_quantity cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200720_113316_split_audit_quantity cannot be reverted.\n";

        return false;
    }
    */
}
