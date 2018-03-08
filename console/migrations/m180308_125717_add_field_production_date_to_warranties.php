<?php

use yii\db\Migration;

/**
 * Class m180308_125717_add_field_production_date_to_warranties
 */
class m180308_125717_add_field_production_date_to_warranties extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('{{%warranties}}', 'production_date', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('{{%warranties}}', 'production_date');
    }

}
