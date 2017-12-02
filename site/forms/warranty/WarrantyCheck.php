<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 02.12.17
 * Time: 18:59
 */

namespace site\forms\warranty;


use himiklab\yii2\recaptcha\ReCaptchaValidator;
use yii\base\Model;

class WarrantyCheck extends Model
{
    public $warrantyNumber;
    public $reCaptcha;

    public function rules(): array
    {
        return [
            [['warrantyNumber'], 'required'],
            [['warrantyNumber'], 'string'],
            [['reCaptcha'], ReCaptchaValidator::className(),
                'secret' => \Yii::$app->params['reCaptchaSecretKey'],
                'uncheckedMessage' => 'Пожалуйста, подтвердите что вы не бот'
            ]
        ];
    }
}