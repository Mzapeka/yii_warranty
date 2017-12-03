<?php
namespace site\forms\auth;

use himiklab\yii2\recaptcha\ReCaptchaValidator;
use yii\base\Model;
use site\entities\User\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $phone;
    public $password;
    public $company;
    public $adress;

    public $password_repeat;
    public $reCaptcha;
    public $policy;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => User::class, 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'This email address has already been taken.'],

            [['password', 'password_repeat'], 'required'],
            ['password', 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Введенные пароли должны совпадать.'],

            ['phone', 'required'],
            ['phone', 'integer'],

            ['company', 'required'],
            ['company', 'string', 'min' => 4],

            ['adress', 'required'],
            ['adress', 'string', 'min' => 10],

            ['policy', 'in', 'range' => [1], 'message' => 'Для регистрации Вам нужно принять политику безопасности'],

            [['reCaptcha'], ReCaptchaValidator::className(),
                'secret' => \Yii::$app->params['reCaptchaSecretKey'],
                'uncheckedMessage' => 'Пожалуйста, подтвердите что вы не бот'
            ],
        ];
    }
}
