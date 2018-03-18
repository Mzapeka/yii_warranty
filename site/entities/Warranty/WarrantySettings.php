<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 18.03.18
 * Time: 14:19
 */

namespace site\entities\Warranty;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * StartPageSetting model
 *
 * @property int $id
 * @property string $key
 * @property string $title
 * @property string $value
 * @property string $unit
 * @property string $description
 *
 */

class WarrantySettings extends ActiveRecord
{
    public function attributeLabels()
    {
        return self::labels();
    }

    public static function labels($name=null)
    {
        $labelsArray = array(
            'key' => 'ID параметра',
            'title' => 'Имя',
            'value' => 'Значение',
            'unit' => 'Единица измерения',
            'description' => 'Описание',
        );
        if(!is_null($name)){
            if(ArrayHelper::keyExists($name, $labelsArray)){
                return $labelsArray[$name];
            }
            return null;
        }
        return $labelsArray;
    }

    public function edit(
        string $value,
        string $description = null
    ):void
    {
        $this->value = $value;
        $this->description = $description;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%warranty_settings}}';
    }

}