<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 05.10.17
 * Time: 0:16
 */

namespace site\forms\customer;


use site\entities\Customer\Customer;
use yii\base\Model;

class CustomerEditForm extends Model
{

    public $dealer_id;
    public $email;
    public $customer_name;
    public $adress;
    public $phone;

    public $_customer;

    public function __construct(Customer $customer, array $config = [])
    {
        $this->dealer_id = $customer->dealer_id;
        $this->email = $customer->email;
        $this->customer_name = $customer->customer_name;
        $this->adress = $customer->adress;
        $this->phone = $customer->phone;
        parent::__construct($config);
    }

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