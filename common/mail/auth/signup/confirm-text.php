<?php

/* @var $this yii\web\View */
/* @var $user \site\entities\User\User */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/signup/confirm', 'token' => $user->email_confirm_token]);
?>
Здравствуйте, <?= $user->username ?>,

Для подтверждения Вашего аккаунта, перейдите пожалуйста по ссылке ниже:

<?= $confirmLink ?>
