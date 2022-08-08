<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%qar}}`.
 */
class m201006_145309_drop_farmer_column_from_qar_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('fk_qar-farmer', '{{%qar}}');
        $this->dropColumn('{{%qar}}', 'farmer');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%qar}}', 'farmer', $this->integer());
    }
}
