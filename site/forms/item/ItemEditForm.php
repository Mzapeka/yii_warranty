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

    public $name;
    public $description;
    public $disabled;
    public $category_id;
    public $document;

    public $_item;

    public function __construct(Item $item, array $config = [])
    {
        $this->name = $item->name;
        $this->category_id = $item->category_id;
        $this->description = $item->description;
        $this->disabled = $item->disabled;
        $this->document = $item->file_name;
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name', 'category_id'], 'required'],
            [['name', 'description'], 'string', 'max' => 255],
            [['document'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf, docx, xlsx, pptx, jpg'],
            [['disabled'], 'default', 'value' => 0],
        ];
    }
}