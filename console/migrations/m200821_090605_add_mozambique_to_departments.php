<?php

use yii\db\Migration;

/**
 * Class m200821_090605_add_mozambique_to_departments
 */
class m200821_090605_add_mozambique_to_departments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Set postal_code to 10
        $this->alterColumn("departments", "postal_code", $this->string(32)->notNull());

        // Insert Mozambique data
        $this->insert('departments', array(
            'country_code' => 'MZ',
            'name' => 'Cabo Delgado',
            'postal_code' => 'CD'
        ));
        $this->insert('departments', array(
            'country_code' => 'MZ',
            'name' => 'Gaza',
            'postal_code' => 'GA'
        ));
        $this->insert('departments', array(
            'country_code' => 'MZ',
            'name' => 'Inhambane',
            'postal_code' => 'IN'
        ));
        $this->insert('departments', array(
            'country_code' => 'MZ',
            'name' => 'Manica',
            'postal_code' => 'MN'
        ));
        $this->insert('departments', array(
            'country_code' => 'MZ',
            'name' => 'Maputo',
            'postal_code' => '7278'
        ));
        $this->insert('departments', array(
            'country_code' => 'MZ',
            'name' => 'Maputo',
            'postal_code' => 'MP'
        ));
        $this->insert('departments', array(
            'country_code' => 'MZ',
            'name' => 'Nampula',
            'postal_code' => 'NM'
        ));
        $this->insert('departments', array(
            'country_code' => 'MZ',
            'name' => 'Niassa',
            'postal_code' => 'NS'
        ));
        $this->insert('departments', array(
            'country_code' => 'MZ',
            'name' => 'Sofala',
            'postal_code' => 'SO'
        ));
        $this->insert('departments', array(
            'country_code' => 'MZ',
            'name' => 'Tete',
            'postal_code' => 'TE'
        ));
        $this->insert('departments', array(
            'country_code' => 'MZ',
            'name' => 'Zambezia',
            'postal_code' => 'ZA'
        ));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200821_090605_add_mozambique_to_departments cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200821_090605_add_mozambique_to_departments cannot be reverted.\n";

        return false;
    }
    */
}
