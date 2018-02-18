<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user \site\entities\User\User */

$confirmLink = Yii::$app->get('backendUrlManager')->createAbsoluteUrl(['user/activate', 'id' => $user->id]);
?>
<div class="password-reset">
    <p>Здравствуйте,</p>

    <p>Новый пользователь зарегистрировался.</p>

    <table border="1">
        <tr>
            <th>Данные пользователя</th>
        </tr>
        <tr>
            <td>Имя пользователя</td>
            <td><?= Html::encode($user->username) ?></td>
        </tr>
        <tr>
            <td>Компания</td>
            <td><?= Html::encode($user->company) ?></td>
        </tr>
        <tr>
            <td>Адрес</td>
            <td><?= Html::encode($user->adress) ?></td>
        </tr>
        <tr>
            <td>Телефон</td>
            <td><?= Html::encode($user->phone) ?></td>
        </tr>
    </table>

    <p>Для активации аккаунта пользователя, перейдите пожалуйста по ссылке ниже:</p>

    <p><?= Html::a(Html::encode($confirmLink), $confirmLink) ?></p>
</div>
