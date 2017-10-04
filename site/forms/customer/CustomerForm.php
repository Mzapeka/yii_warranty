<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 05.10.17
 * Time: 0:16
 */

namespace site\forms\customer;


class CustomerForm
{

    public $dealer_id;
    public $email;
    public $customer_name;
    public $adress;
    public $phone;

    public function rules(): array
    {
        return [
            [['email', 'dealer_id', 'customer_name'], 'required'],
            [['customer_name', 'adress', 'phone'], 'string', 'max' => 255],
            [['phone', 'adress'], 'default', 'value' => null],
            ['email', 'email'],
            ['dealer_id', 'integer'],
        ];
    }
}