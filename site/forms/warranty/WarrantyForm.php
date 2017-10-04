<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 03.10.17
 * Time: 22:56
 */

namespace site\forms\warranty;


use site\entities\Warranty\Warranty;
use yii\base\Model;

class WarrantyForm extends Model
{

    public $device_name;
    public $customer_id;
    public $part_number;
    public $serial_number;
    public $invoice_number;
    public $act_number;
    public $invoice_date;
    public $act_date;
    public $status;

    public function rules(): array
    {
        return [
            [['device_name', 'customer_id', 'part_number', 'serial_number', 'invoice_number', 'invoice_date', 'status'], 'required'],
            [['device_name', 'part_number', 'serial_number', 'invoice_number'], 'string', 'max' => 255],
            [['act_number', 'act_date'], 'default', 'value' => null],
            [['invoice_date','act_date'], 'date'],
            [['customer_id', 'status'], 'integer'],
        ];
    }

}