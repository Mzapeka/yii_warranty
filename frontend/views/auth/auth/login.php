<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \site\forms\auth\LoginForm */

use himiklab\yii2\recaptcha\ReCaptcha;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Страница входа';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">

    <div class="col-sm-6">
        <div class="well">
            <h2>Вход в систему</h2>
            <p><strong>Я зарегистрированный пользователь</strong></p>

            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form->field($model, 'username')->textInput()->label('E-mail') ?>

            <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>

            <?= $form->field($model, 'rememberMe')->checkbox()->label('Запомнить меня') ?>

            <?= $form->field($model, 'reCaptcha')->widget(
                ReCaptcha::className(),
                ['siteKey' => Yii::$app->params['reCaptchaSiteKey']]
            )->label('')?>

            <div style="color:#999;margin:1em 0">
                Если вы забыли пароль, вы можете его <?= Html::a('сбросить', ['auth/reset/request']) ?>.
            </div>

            <div>
                <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
