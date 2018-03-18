<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 19.11.17
 * Time: 13:41
 */

namespace site\forms\warranty;


use site\entities\Warranty\WarrantySettings;
use yii\base\Model;


class WarrantySettingsEditForm extends Model
{
    public $value;
    public $description;

    public function __construct(WarrantySettings $warranty, array $config = [])
    {
        $this->value = $warranty->value;
        $this->description = $warranty->description;
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['value'], 'required'],
            [['description'], 'default', 'value' => null],
            [['description'], 'string', 'max' => 450],
            [['value'], 'integer'],
        ];
    }
}