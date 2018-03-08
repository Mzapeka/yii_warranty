<?php

namespace site\helpers;

use site\access\Rbac;
use site\entities\Customer\Customer;
use site\entities\User\User;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class UserHelper
{

    public static function getUserNameList():array
    {
        $userList = User::find()->select(['id', 'username'])->asArray()->all();
        return ArrayHelper::map($userList, 'id', 'username');
    }

    public static function getUserNameByID($id): ? string
    {
        return User::findOne($id)->username;
    }

    public static function statusList(): array
    {
        return [
            User::STATUS_WAIT => 'Wait',
            User::STATUS_ACTIVE => 'Active',
        ];
    }

    public static function statusName($status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel($status): string
    {
        switch ($status) {
            case User::STATUS_WAIT:
                $class = 'label label-default';
                break;
            case User::STATUS_ACTIVE:
                $class = 'label label-success';
                break;
            default:
                $class = 'label label-default';
        }

        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $class,
        ]);
    }

    public static function groupDescription($group):string
    {
        $roles = ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description');
        return $roles[$group];
    }

    public static function groupLabel($userGroup):string
    {
        switch ($userGroup){
            case Rbac::ROLE_DEALER:
                $class = 'label label-success';
                break;
            case Rbac::ROLE_ADMIN:
                $class = 'label label-danger';
                break;
            case Rbac::ROLE_GUEST:
                $class = 'label label-primary';
                break;
            default:
                $class = 'label label-default';
                break;
        }

        return \yii\bootstrap\Html::tag('span', self::groupDescription($userGroup), ['class'=>$class,]);
    }

    public static function getUserNameByCustomerId(int $customerId) :?string
    {
        return Customer::findOne(['id' => $customerId])->getUser()->one()->username;
    }

}