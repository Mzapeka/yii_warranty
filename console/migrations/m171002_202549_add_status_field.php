<?php

use yii\db\Migration;

class m171002_202549_add_status_field extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%warranties}}', 'status', $this ->smallInteger()->defaultValue(10));

        $this->createIndex('{{%idx-warranties-status}}', '{{%warranties}}', 'status');
    }

    public function safeDown()
    {
        $this->dropIndex('{{%idx-warranties-status}}', '{{%warranties}}');
        $this->dropColumn('{{%warranties}}','status');
    }

}
