<?php

use yii\db\Migration;

/**
 * Handles the creation of table `catalog_items`.
 */
class m171225_133929_create_catalog_items_table extends Migration
{
    const TABLE_NAME = '{{%catalog_items}}';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->bigPrimaryKey(),
            'name' => $this->string(255)->notNull(),
            'file_type' => $this->string(255)->defaultValue('file'),
            'file_size' => $this->string(255),
            'old_id' => $this->integer()->Null()->defaultValue(null),
            'category_id' => $this->integer()->notNull(),
            'disabled' => $this->boolean()->notNull()->defaultValue(false),
            'description' => $this->string()->Null()->defaultValue(null),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
