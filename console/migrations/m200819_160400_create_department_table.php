<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%departments}}`.
 */
class m200819_160400_create_department_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Change table options for mysql driver
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        // Create table statement
        $this->createTable('{{%departments}}', [
            'id' => $this->primaryKey(),
            'country_code' => $this->string(2)->notNull(),
            'name' => $this->string(255)->notNull(),
            'postal_code' => $this->string(2)->null(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP"),
        ], $tableOptions);

        // Insert Departments data
        $this->insert('departments', array(
            'country_code' => 'BJ',
            'name' => 'Alibori',
            'postal_code' => 'AL'
        ));
        $this->insert('departments', array(
            'country_code' => 'BJ',
            'name' => 'Atakora',
            'postal_code' => 'AK'
        ));
        $this->insert('departments', array(
            'country_code' => 'BJ',
            'name' => 'Atlantique',
            'postal_code' => 'AQ'
        ));
        $this->insert('departments', array(
            'country_code' => 'BJ',
            'name' => 'Borgou',
            'postal_code' => 'BO'
        ));
        $this->insert('departments', array(
            'country_code' => 'BJ',
            'name' => 'Collines',
            'postal_code' => 'CL'
        ));
        $this->insert('departments', array(
            'country_code' => 'BJ',
            'name' => 'Kouffo',
            'postal_code' => 'CF'
        ));
        $this->insert('departments', array(
            'country_code' => 'BJ',
            'name' => 'Donga',
            'postal_code' => 'DO'
        ));
        $this->insert('departments', array(
            'country_code' => 'BJ',
            'name' => 'Littoral',
            'postal_code' => 'LI'
        ));
        $this->insert('departments', array(
            'country_code' => 'BJ',
            'name' => 'Mono',
            'postal_code' => 'MO'
        ));
        $this->insert('departments', array(
            'country_code' => 'BJ',
            'name' => 'Ouémé',
            'postal_code' => 'OU'
        ));
        $this->insert('departments', array(
            'country_code' => 'BJ',
            'name' => 'Plateau',
            'postal_code' => 'PL'
        ));
        $this->insert('departments', array(
            'country_code' => 'BJ',
            'name' => 'Zou',
            'postal_code' => 'ZO'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%departments}}');
    }
}

