<?php

use yii\db\Migration;

class m170929_160105_add_comany_and_adress_filds extends Migration
{
/*    public function safeUp()
    {

    }

    public function safeDown()
    {
        echo "m170929_160105_add_comany_and_adress_filds cannot be reverted.\n";

        return false;
    }*/


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('{{%users}}', 'company', $this->string()->notNull());
        $this->addColumn('{{%users}}', 'adress', $this->string()->notNull());

        $this->createIndex('{{%idx-users-company}}', '{{%users}}', 'company', true);
        $this->createIndex('{{%idx-users-adress}}', '{{%users}}', 'adress', true);
    }


    public function down()
    {
        $this->dropColumn('{{%users}}', 'company');
        $this->dropColumn('{{%users}}', 'adress');
    }

}
