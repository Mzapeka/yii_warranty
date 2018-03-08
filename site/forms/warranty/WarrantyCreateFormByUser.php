<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 03.10.17
 * Time: 22:56
 */

namespace site\forms\warranty;


use site\helpers\WarrantyHelper;
use yii\base\Model;

class WarrantyCreateFormByUser extends Model
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

            //если был введен номер акта - нужно заполнить дату и наоборот
            ['act_date', 'required',
                'when' => function($form) {
                    return $form->act_number != '';
                },
                'skipOnError' => false,
                'message' => 'Заполните дату акта ввода в эксплуатацию.'
            ],
            [['act_number'], 'required',
                'when' => function($model) {
                    return $model->act_date != null;
                },
                'skipOnError' => false,
                'message' => 'Заполните номер акта ввода в эксплуатацию.'
            ],

            ['invoice_date', 'compare',
                'compareValue'=> time(),
                'operator' => '<',
                'type' => 'number',
                'message' => 'Дата инвойса не может быть больше сегоднешнего дня',
            ],

            ['invoice_date', 'compare',
                'compareValue'=> WarrantyHelper::getMinTimeInvoiceReg(),
                'operator' => '>=',
                'type' => 'number',
                'message' => 'Дата инвойса должна быть не раньше чем '.date('Y-m-d', WarrantyHelper::getMinTimeInvoiceReg()),
            ],

            ['act_date', 'compare',
                'compareValue'=> time(),
                'operator' => '<',
                'type' => 'number',
                'message' => 'Дата акта не может быть больше сегоднешнего дня',
            ],

            ['act_date', 'compare',
                'compareAttribute' => 'invoice_date',
                'operator' => '>=',
                'type' => 'number',
                'message' => 'Дата акта не может быть меньше даты инвойса',
            ],

            ['act_date', function ($attribute) {

                if ($this->$attribute > WarrantyHelper::getMaxTimeActReg($this->invoice_date)) {
                    $this->addError($attribute, 'Дата акта ввода в эксплуатацию должна быть не позже чем '.date('Y-m-d', WarrantyHelper::getMaxTimeActReg($this->invoice_date)));
                }
            }],



        ];
    }

}