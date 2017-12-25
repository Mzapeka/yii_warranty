<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 02.12.17
 * Time: 16:52
 */

use himiklab\yii2\recaptcha\ReCaptcha;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \site\forms\warranty\WarrantyCheck */


$this->title = 'Проверка гарантии';

$form = ActiveForm::begin(['id' => 'check-form']);

echo $form->field($model, 'warrantyNumber')->textInput(['class'=>'check-warranty-input form-control'])->label('Серийный номер оборудования');
echo $form->field($model, 'reCaptcha')->widget(
    ReCaptcha::className(),
    ['siteKey' => Yii::$app->params['reCaptchaSiteKey'],
        //'widgetOptions' => ['class' => 'col-sm-offset-6']
    ]
//['widgetOptions'=>['class'=>'pull-right']]
)->label('');

echo Html::submitButton('Проверить', ['class' => 'btn btn-primary', 'name' => 'check-button']);

ActiveForm::end();


