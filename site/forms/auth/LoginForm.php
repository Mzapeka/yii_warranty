<?php
namespace site\forms\auth;

use himiklab\yii2\recaptcha\ReCaptchaValidator;
use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;
    public $reCaptcha;

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            [['reCaptcha'], ReCaptchaValidator::className(),
                'secret' => Yii::$app->params['reCaptchaSecretKey'],
                'uncheckedMessage' => 'Пожалуйста, подтвердите что вы не бот'
            ],
        ];
    }
}
