<?php

use yii\db\Migration;

/**
 * Handles the creation of table `bts_nikname`.
 */
class m171122_185607_create_bts_nikname_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('bts_nikname', [
            'id' => $this->integer(),
            'btsId' => $this->string(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('bts_nikname');
    }
}
