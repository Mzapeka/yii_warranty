<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \site\forms\auth\SignupForm */

use himiklab\yii2\recaptcha\ReCaptcha;
use kartik\form\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;


$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Пожалуйста заполните все поля для регистрации:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Имя пользователя') ?>

                <?= $form->field($model, 'email')->label('E-mail') ?>

                <?= $form->field($model, 'phone', ['addon' => ['prepend' => ['content'=>'+']]])->label('Телефонный номер') ?>

                <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>

                <?= $form->field($model, 'password_repeat')->passwordInput()->label('Введите пароль еще раз') ?>

                <?= $form->field($model, 'company')->textInput()->label('Название компании') ?>

                <?= $form->field($model, 'adress')->textarea()->label('Адрес') ?>

                <?= $form->field($model, 'policy')->checkbox(['label'=>'Я принимаю '.Html::a('политику безопасности Bosch', Url::to('policy'))]) ?>

                <?= $form->field($model, 'reCaptcha')->widget(
                    ReCaptcha::className(),
                    ['siteKey' => Yii::$app->params['reCaptchaSiteKey']]
                )->label('')?>

                <div class="form-group">
                    <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
