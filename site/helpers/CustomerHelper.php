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
use Yii;
use yii\helpers\ArrayHelper;

class CustomerHelper
{
    public static function getCustomerNameList($userId = null):array
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

    public static function getCustomerListBelongToUser(): ?array
    {
        /**@var $customers array*/
        $customers = User::findOne(Yii::$app->getUser()->id)->getCustomer()->select(['id', 'customer_name'])->asArray()->all();
        if($customers){
            return ArrayHelper::map($customers, 'id', 'customer_name');
        }
        return null;
    }

    public static function getMappedCustomerList(): ?array
    {
        /**@var $customers array*/
        $customers = Customer::find()->select(['id', 'customer_name'])->asArray()->all();
        if($customers){
            return ArrayHelper::map($customers, 'id', 'customer_name');
        }
        return null;
    }

    public static function getCustomerNameByID($id): ? string
    {
        return Customer::findOne($id)->customer_name;
    }

    public static function isCustomerBelongToUser(int $customerId): bool
    {
        $customer = Customer::findOne($customerId);
        if($customer){
            return $customer->getUser()->one()->id == Yii::$app->getUser()->id;
        }
        return false;
    }

}