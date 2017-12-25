<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 05.10.17
 * Time: 0:16
 */

namespace site\forms\item;

/**
 * Item Create Form model
 *
 * @property string $file_type
 * @property string $name
 * @property string $file_size
 * @property string $description
 * @property integer $disabled
 * @property integer $old_id
 * @property integer $category_id
 *

 */

use yii\base\Model;

class ItemCreateForm extends Model
{
    public $file_type;
    public $name;
    public $file_size;
    public $description;
    public $disabled;
    public $old_id;
    public $category_id;

    public function rules(): array
    {
        return [
            [['name', 'category_id'], 'required'],
            [['name', 'file_type', 'file_size', 'description'], 'string', 'max' => 255],
//            [['old_id'], 'default', 'value' => null],
            [['disabled'], 'default', 'value' => 0],
            ['old_id', 'integer'],
        ];
    }

}