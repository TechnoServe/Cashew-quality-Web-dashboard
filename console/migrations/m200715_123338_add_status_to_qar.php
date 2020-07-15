<?php

use yii\db\Migration;

/**
 * Class m200715_123338_add_status_to_qar
 */
class m200715_123338_add_status_to_qar extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("qar", "status", $this->integer()->after("company_id")->defaultValue(1));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200715_123338_add_status_to_qar cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200715_123338_add_status_to_qar cannot be reverted.\n";

        return false;
    }
    */
}
