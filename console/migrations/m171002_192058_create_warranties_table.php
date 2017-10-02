<?php

use yii\db\Migration;

/**
 * Handles the creation of table `warranties`.
 */
class m171002_192058_create_warranties_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%warranties}}', [
            'id' => $this->primaryKey(),
            'customer_id' => $this->integer()->notNull(),
            'device_name' => $this->string()->notNull(),
            'part_number' => $this->string()->notNull(),
            'serial_number' => $this->string()->notNull(),
            'invoice_number' => $this->string()->notNull(),
            'act_number' => $this->string(),
            'invoice_date' => $this->integer()->unsigned()->notNull(),
            'act_date' => $this->integer()->unsigned(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-warranties-device_name}}', '{{%warranties}}', 'device_name');
        $this->createIndex('{{%idx-warranties-part_number}}', '{{%warranties}}', 'part_number');
        $this->createIndex('{{%idx-warranties-customer_id}}', '{{%warranties}}', 'customer_id');

        $this->addForeignKey('{{%fk-warranties-customer_id}}', '{{%warranties}}', 'customer_id', '{{%customers}}', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%warranties}}');
    }
}
