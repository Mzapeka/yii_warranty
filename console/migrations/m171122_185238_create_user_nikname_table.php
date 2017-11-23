<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_nikname`.
 */
class m171122_185238_create_user_nikname_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('user_nikname', [
            'id' => $this->integer(),
            'userId' => $this->string(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('user_nikname');
    }
}
