<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 25.11.17
 * Time: 21:17
 */

namespace app\modules\importData\models;


use yii\db\ActiveRecord;


/**
 * This is the model class for table "warranty_register".
 *
 * @property $id int
 * @property $oldId int
 */

class WarrantyRegister extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'warranty_register';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'oldId'], 'integer'],
            ['oldId', 'unique'],
        ];
    }
}