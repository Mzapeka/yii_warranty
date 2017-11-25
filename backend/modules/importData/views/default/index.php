<?php

/* @var $this yii\web\View */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $form yii\bootstrap\ActiveForm */
/* @var $notification string*/
/* @var $model \app\modules\importData\forms\OldDbCredentialForm */

$this->title = 'Импорт данных из старой базы';

?>

<div class="importData-default-index">
    <?php Pjax::begin(); ?>
    <?php $form = ActiveForm::begin(['action'=> Url::to(['db-import']), 'id'=>'connection-form']); ?>
    <?= $form->field($model,'path')->textInput()->label('Путь к базе')?>
    <?= $form->field($model,'dbName')->textInput()->label('Имя базы')?>
    <?= $form->field($model,'userName')->textInput()->label('Имя пользователя')?>
    <?= $form->field($model,'pass')->passwordInput()->label('Пароль')?>
    <div class="form-group">
        <?= Html::submitButton('Загрузить', ['class' => 'btn btn-primary']) ?>
        <?= Html::button('Проверить соединение', ['class' => 'btn btn-warning', 'id'=>'db-check-button']) ?>
    </div>
    <?php ActiveForm::end(); ?>

    <div class="notify">
        <?= $notification?>
    </div>

    <?php Pjax::end(); ?>
</div>
