<?php

use yii\db\Migration;

/**
 * Class m200715_131216_add_longitude_and_latitude_to_site
 */
class m200715_131216_add_longitude_and_latitude_to_site extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("site", "map_location", $this->string(255)->null()->after("image"));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200715_131216_add_longitude_and_latitude_to_site cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200715_131216_add_longitude_and_latitude_to_site cannot be reverted.\n";

        return false;
    }
    */
}
