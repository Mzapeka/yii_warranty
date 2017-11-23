<?php

namespace site\forms\User;

use site\entities\User\User;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class UserCreateForm extends Model
{
    public $username;
    public $email;
    public $phone;
    public $password;
    public $group;
    public $company;
    public $adress;

    public function rules(): array
    {
        return [
            [['username', 'email', 'phone', 'group', 'company', 'adress'], 'required'],
            ['email', 'email'],
            [['username', 'email', 'company', 'adress'], 'string', 'max' => 255],
            [['username', 'email', 'phone'], 'unique', 'targetClass' => User::class],
            ['password', 'string', 'min' => 6],
            ['phone', 'string'],
        ];
    }

    public function rolesList(): array
    {
        return ArrayHelper::map(\Yii::$app->authManager->getRoles(), 'name', 'description');
    }
}