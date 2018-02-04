<?php

use yii\db\Migration;

/**
 * Class m180203_192104_add_fields_to_items_table
 */
class m180203_192104_add_fields_to_items_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('{{%catalog_items}}','file_name', $this->string(255)->null());
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('{{%catalog_items}}', 'file_name');
    }

}
