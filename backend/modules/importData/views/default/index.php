<?php

/* @var $this yii\web\View */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\Url;

/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\modules\importData\forms\OldDbCredentialForm */

$this->title = 'Импорт данных из старой базы';

?>

<div class="importData-default-index">

    <?php $form = ActiveForm::begin(['action'=> Url::to(['test'])]); ?>
    <?= $form->field($model,'path')->textInput()->label('Путь к базе')?>
    <?= $form->field($model,'dbName')->textInput()->label('Имя базы')?>
    <?= $form->field($model,'userName')->textInput()->label('Имя пользователя')?>
    <?= $form->field($model,'pass')->passwordInput()->label('Пароль')?>
    <div class="form-group">
        <?= Html::submitButton('Загрузить', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
