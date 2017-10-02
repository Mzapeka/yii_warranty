<?php

use yii\db\Migration;

class m171002_202549_add_status_field extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%warranties}}', 'status', $this ->smallInteger()->notNull()->defaultValue(10));

        $this->createIndex('{{%idx-warranties-status}}', '{{%warranties}}', 'status');
    }

    public function safeDown()
    {
        echo "m171002_202549_add_status_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171002_202549_add_status_field cannot be reverted.\n";

        return false;
    }
    */
}
