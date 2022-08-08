<?php

use yii\db\Migration;

/**
 * Class m200901_071533_add_expo_token_to_user
 */
class m200901_071533_add_expo_token_to_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("user", "expo_token", $this->text()->null());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200901_071533_add_expo_token_to_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200901_071533_add_expo_token_to_user cannot be reverted.\n";

        return false;
    }
    */
}
