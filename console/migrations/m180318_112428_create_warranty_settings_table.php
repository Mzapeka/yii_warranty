<?php

use yii\db\Migration;

/**
 * Handles the creation of table `warranty_settings`.
 */
class m180318_112428_create_warranty_settings_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $tableName = 'warranty_settings';
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable($tableName, [
            'id' => $this->primaryKey(),
            'key' => $this->string()->unique()->notNull(),
            'title' => $this->string(),
            'value' => $this->string(),
            'unit' => $this->string(),
            'description' => $this->string(),
        ], $tableOptions);

        $this->insert($tableName, [
            'key' => 'extendedWarrantyTime',
            'title' => 'Расширенная гарантия',
            'value' => '12',
            'unit' => 'мес.',
            'description' => 'Срок расширенной гарантии'
        ]);

        $this->insert($tableName, [
            'key' => 'standardWarrantyTime',
            'title' => 'Стандартная гарантия',
            'value' => '12',
            'unit' => 'мес.',
            'description' => 'Срок стандартной гарантии'
        ]);

        $this->insert($tableName, [
            'key' => 'minTimeInvoiceReg',
            'title' => 'Срок регистрации от момента продажи',
            'value' => '3',
            'unit' => 'мес.',
            'description' => 'В течении этого времени от момента продажи (даты инвойса) можно зарегистрировать гарантию'
        ]);

        $this->insert($tableName, [
            'key' => 'maxTimeActReg',
            'title' => 'Время акта ввода в эксплуатацию',
            'value' => '2',
            'unit' => 'мес.',
            'description' => 'В течении этого времени от момента продажи можно ввести в эксплуатацию'
        ]);


    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('warranty_settings');
    }
}
