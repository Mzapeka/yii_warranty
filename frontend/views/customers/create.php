<?php

use site\entities\Customer\Customer;
use site\helpers\UserHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model site\entities\Customer\Customer */

$this->title = 'Новый клиент';
$this->params['breadcrumbs'][] = ['label' => 'Клиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-create">

    <h1><?= Html::encode($this->title) ?></h1>


        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'customer_name')->textInput(['maxlength' => true])->label(Customer::labels('customer_name')) ?>
        <?= $form->field($model, 'email')->textInput(['maxlength' => true])->label(Customer::labels('email')) ?>
        <?= $form->field($model, 'adress')->textInput(['maxlength' => true])->label(Customer::labels('adress')) ?>
        <?= $form->field($model, 'phone')->textInput(['maxlength' => true])->label(Customer::labels('phone')) ?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>


</div>
