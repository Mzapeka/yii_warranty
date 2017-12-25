<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 05.10.17
 * Time: 0:16
 */

namespace site\forms\item;


use site\entities\Catalog\Item;
use yii\base\Model;

class ItemEditForm extends Model
{

    public $file_type;
    public $name;
    public $file_size;
    public $description;
    public $disabled;
    public $old_id;
    public $category_id;

    public $_item;

    public function __construct(Item $item, array $config = [])
    {
        $this->name = $item->name;
        $this->category_id = $item->category_id;
        $this->file_type = $item->file_type;
        $this->file_size = $item->file_size;
        $this->description = $item->description;
        $this->disabled = $item->disabled;
        $this->old_id = $item->old_id;
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name', 'category_id'], 'required'],
            [['name', 'file_type', 'file_size', 'description'], 'string', 'max' => 255],
            [['old_id'], 'default', 'value' => null],
            [['disabled'], 'default', 'value' => 0],
            ['old_id', 'integer'],
        ];
    }
}