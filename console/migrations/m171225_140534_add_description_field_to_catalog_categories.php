<?php

use yii\db\Migration;

/**
 * Class m171225_140534_add_description_field_to_catalog_categories
 */
class m171225_140534_add_description_field_to_catalog_categories extends Migration
{
    /**
     * @inheritdoc
     */

    public function up()
    {
        $this->addColumn('{{%catalog_categories}}', 'description', $this->string()->notNull());
    }

    public function down()
    {
        $this->dropColumn('{{%catalog_categories}}', 'description');
    }

}
