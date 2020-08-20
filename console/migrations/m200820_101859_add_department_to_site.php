<?php

use yii\db\Migration;

/**
 * Class m200820_101859_add_department_to_site
 */
class m200820_101859_add_department_to_site extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Add department to site
        $this->addColumn("site", "department_id", $this->integer()->notNull()->after("company_id"));

        // Set postal_code to required
        $this->alterColumn("departments", "postal_code", $this->string(2)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200820_101859_add_department_to_site cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200820_101859_add_department_to_site cannot be reverted.\n";

        return false;
    }
    */
}
