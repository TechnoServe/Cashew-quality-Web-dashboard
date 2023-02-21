<?php

use yii\db\Migration;

/**
 * Class m200903_064425_add_reminder_time_to_qar
 */
class m200903_064425_add_reminder_time_to_qar extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("qar", "reminder1", $this->dateTime()->null()->after("status"));
        $this->addColumn("qar", "reminder2", $this->dateTime()->null()->after("reminder1"));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200903_064425_add_reminder_time_to_qar cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200903_064425_add_reminder_time_to_qar cannot be reverted.\n";

        return false;
    }
    */
}
