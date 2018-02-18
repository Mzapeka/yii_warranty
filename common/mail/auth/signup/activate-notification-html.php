<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user \site\entities\User\User */

$confirmLink = Yii::$app->get('frontendUrlManager')->createAbsoluteUrl(['site/login']);
?>
<div class="password-reset">
    <p>Здравствуйте, <?= Html::encode($user->username) ?>,</p>

    <p>Ваша учетная запись активирована.</p>

    <p>Чтобы войти в личный кабинет, перейдите пожалуйста по ссылке ниже:</p>

    <p><?= Html::a('Вход в личный кабинет', $confirmLink) ?></p>
</div>
