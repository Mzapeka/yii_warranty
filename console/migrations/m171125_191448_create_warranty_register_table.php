<?php

use yii\db\Migration;

/**
 * Handles the creation of table `warranty_register`.
 */
class m171125_191448_create_warranty_register_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('warranty_register', [
            'id' => $this->primaryKey(),
            'oldId' => $this->integer()->unique(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('warranty_register');
    }
}
