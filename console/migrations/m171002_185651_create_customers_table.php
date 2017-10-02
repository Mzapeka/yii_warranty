<?php

use yii\db\Migration;

/**
 * Handles the creation of table `customers`.
 */
class m171002_185651_create_customers_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%customers}}', [
            'id' => $this->primaryKey(),
            'dealer_id' => $this->integer()->notNull(),
            'email' => $this->string()->notNull(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
            'customer_name' => $this->string()->notNull(),
            'adress' => $this->string(),
            'phone' => $this->string(),
        ], $tableOptions);

        $this->createIndex('{{%idx-customers-email}}', '{{%customers}}', 'email', true);
        $this->createIndex('{{%idx-customers-dealer_id}}', '{{%customers}}', 'dealer_id');
        $this->createIndex('{{%idx-customers-customer_name}}', '{{%customers}}', 'customer_name');

        $this->addForeignKey('{{%fk-customers-dealer_id}}', '{{%customers}}', 'dealer_id', '{{%users}}', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%customers}}');
    }
}
