<?php

use yii\db\Migration;

/**
 * Class m200629_123839_add_languages_to_user_table
 */
class m200629_123839_add_fields_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("user", "first_name", $this->string(255)->notNull()->after("username"));
        $this->addColumn("user", "middle_name", $this->string(255)->null()->after("first_name"));
        $this->addColumn("user", "last_name", $this->string(255)->notNull()->after("middle_name"));
        $this->alterColumn("user", "created_at", $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"));
        $this->alterColumn("user", "updated_at", $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP"));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200629_123839_add_languages_to_user_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200629_123839_add_languages_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
