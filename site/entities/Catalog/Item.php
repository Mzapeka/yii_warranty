<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 01.10.17
 * Time: 22:30
 */

namespace site\entities\Catalog;
//use app\modules\catalogManager\models\TreeBuilder;
use site\entities\Catalog\queries\ItemQuery;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Customer model
 *
 * @property integer $id
 * @property string $file_type
 * @property string $name
 * @property string $file_size
 * @property string $description
 * @property integer $disabled
 * @property integer $old_id
 * @property integer $category_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $file_name
 *

 */

class Item extends ActiveRecord
{
    public function attributeLabels()
    {
        return self::labels();
    }

    public static function labels($name=null)
    {
        $labelsArray = array(
            'id' => 'ID документа',
            'file_type' => 'Тип файла',
            'name' => 'Название документа',
            'file_size' => 'Размер файла',
            'description' => 'Описание',
            'disabled' => 'Флаг видимости',
            'old_id' => 'ID источника',
            'category_id' => 'ID категории',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата изменения',
            'file_name' => 'Локальный файл'
        );
        if(!is_null($name)){
            if(ArrayHelper::keyExists($name, $labelsArray)){
                return $labelsArray[$name];
            }
            return null;
        }
        return $labelsArray;
    }


    public static function create(
        string $name,
        int $category_id,
        string $file_type = null,
        string $file_size = null,
        string $description = '',
        int $disabled = null,
        int $old_id = null,
        string $file_name = null
    ):self
    {
        $item = new Item();
        $item->name = $name;
        $item->category_id = $category_id;
        $item->file_type = $file_type;
        $item->file_size = $file_size;
        $item->description = $description;
        $item->disabled = $disabled;
        $item->old_id = $old_id;
        $item->file_name = $file_name;
        return $item;
    }


    public function edit(
        string $name,
        int $category_id,
        string $file_type = null,
        string $file_size = null,
        string $description = '',
        int $disabled = null,
        int $old_id = null,
        string $file_name = null
    ):void
    {
        $this->name = $name;
        $this->category_id = $category_id;
        $this->file_type = $file_type;
        $this->file_size = $file_size;
        $this->description = $description;
        $this->disabled = $disabled;
        $this->old_id = $old_id;
        $this->file_name = $file_name;
    }


/*    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(TreeBuilder::class, ['id' => 'category_id']);
    }*/


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%catalog_items}}';
    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public static function find(): ItemQuery
    {
        return new ItemQuery(static::class);
    }

}