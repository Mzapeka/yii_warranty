<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user \site\entities\User\User */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/signup/confirm', 'token' => $user->email_confirm_token]);
?>
<div class="password-reset">
    <p>Здравствуйте, <?= Html::encode($user->username) ?>!</p>

    <p>Для подтверждения Вашего аккаунта, перейдите пожалуйста по ссылке ниже:</p>

    <p><?= Html::a(Html::encode($confirmLink), $confirmLink) ?></p>

    <p>После того как Вы подвердите аккаунт, вам придет сообщение от администратора об активации личного кабинета. После этого Вы сможете пользоваться учетной записью.</p>



</div>
