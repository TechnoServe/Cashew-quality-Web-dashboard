<?php

use yii\db\Migration;

/**
 * Class m200714_093553_add_company_ids
 */
class m200714_093553_add_company_ids extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Add company to user
        $this->addColumn("user", "company_id", $this->integer()->null()->after("status"));
        $this->addForeignKey('fk_user_company_id','user','company_id','company','id');


        // Add fields to qar
        $this->addColumn("qar", "deadline", $this->date()->null()->after("audit_quantity"));
        $this->addColumn("qar", "company_id", $this->integer()->null()->after("deadline"));
        $this->addForeignKey('fk_qar_company_id','qar','company_id','company','id');



        // Add fields to qar details
        $this->addColumn("qar_detail", "sample_number", $this->integer()->null()->after("picture"));



        // Add fields to dite
        $this->addColumn("site", "image", $this->string(255)->null()->after("site_location"));
        $this->addColumn("site", "company_id", $this->integer()->null()->after("image"));
        $this->addForeignKey('fk_site_company_id','site','company_id','company','id');


        // Add fields to qar
        $this->addColumn("user_equipment", "company_id", $this->integer()->null()->after("manufacturing_date"));
        $this->addForeignKey('fk_user_equipment_company_id','user_equipment','company_id','company','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200714_093553_add_company_ids cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200714_093553_add_company_ids cannot be reverted.\n";

        return false;
    }
    */
}
