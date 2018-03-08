<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 19.11.17
 * Time: 13:41
 */

namespace site\forms\warranty;


use site\entities\Warranty\Warranty;
use yii\base\Model;


class WarrantyEditForm extends Model
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
    public $id;
    public $production_date;

    public $_warranty;

    public function __construct(Warranty $warranty, array $config = [])
    {
        $this->customer_id = $warranty->customer_id;
        $this->device_name = $warranty->device_name;
        $this->part_number = $warranty->part_number;
        $this->serial_number = $warranty->serial_number;
        $this->invoice_number = $warranty->invoice_number;
        $this->act_number = $warranty->act_number;
        $this->invoice_date = $warranty->invoice_date;
        $this->act_date = $warranty->act_date;
        $this->status = $warranty->status;
        $this->id = $warranty->id;
        $this->production_date = $warranty->production_date;
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['device_name', 'customer_id', 'part_number', 'serial_number', 'invoice_number', 'invoice_date', 'status'], 'required'],
            [['device_name', 'part_number', 'serial_number', 'invoice_number'], 'string', 'max' => 255],
            [['act_number', 'act_date', 'production_date'], 'default', 'value' => null],
            //[['invoice_date','act_date'], 'date'],
            [['customer_id', 'status'], 'integer'],
            [['invoice_date', 'act_date', 'production_date'], 'filter', 'filter' => function ($value) {
                if(!preg_match("/^[\d\+]+$/",$value) && $value > 0){
                    return strtotime($value);
                }
                else{
                    return $value;
                }
            }],
        ];
    }
}