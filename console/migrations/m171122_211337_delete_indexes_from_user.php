<?php

use yii\db\Migration;

/**
 * Class m171122_211337_delete_indexes_from_user
 */
class m171122_211337_delete_indexes_from_user extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->dropIndex('{{%idx-users-phone}}', '{{%users}}');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->createIndex('{{%idx-users-phone}}', '{{%users}}', 'phone', true);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171122_211337_delete_indexes_from_user cannot be reverted.\n";

        return false;
    }
    */
}
