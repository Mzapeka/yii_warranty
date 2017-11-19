<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 18.11.17
 * Time: 22:51
 */

namespace site\helpers;


use site\entities\Customer\Customer;
use site\entities\User\User;
use yii\helpers\ArrayHelper;

class CustomerHelper
{
    public static function getCustomerNameList():array
    {
        // пакетная выборка с жадной загрузкой
        $customerList = [];
        foreach (User::find()->with('customer')->each() as $user) {
            if(is_array($user->customer)){
                $customersData = [];
                foreach ($user->customer as $customer){
                    $customersData[$customer->id] = $customer->customer_name;
                }
                if($customersData){
                    $customerList[$user->username] = $customersData;
                }
            }
        }

        return $customerList;
    }

    public static function getCustomerNameByID($id): ? string
    {
        return Customer::findOne($id)->customer_name;
    }

}