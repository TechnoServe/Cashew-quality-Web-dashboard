<?php

use yii\db\Migration;

/**
 * Class m201009_090645_alter_site_from_qar_table
 */
class m201009_090645_alter_site_from_qar_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn("qar", 'site');
        $this->addColumn("qar", "site_name", $this->string(255)->notNull()->after("initiator"));
        $this->addColumn("qar", "site_location", $this->text()->notNull()->after("site_name"));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201009_090645_alter_site_from_qar_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201009_090645_alter_site_from_qar_table cannot be reverted.\n";

        return false;
    }
    */
}
