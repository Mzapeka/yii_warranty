<?php

use yii\db\Migration;

class m170930_130751_add_group_fild extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%users}}', 'group', $this->string());

    }

    public function safeDown()
    {
        echo "m170930_130751_add_group_fild cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170930_130751_add_group_fild cannot be reverted.\n";

        return false;
    }
    */
}
