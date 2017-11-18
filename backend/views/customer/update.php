<?php

use site\helpers\UserHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model site\forms\customer\CustomerEditForm */
/* @var $customer site\entities\Customer\Customer */

$this->title = 'Update Customer: '. $model->customer_name;
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $customer->id, 'url' => ['view', 'id' => $customer->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="customer-update">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'dealer_id')->dropDownList(UserHelper::getUserNameList()) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customer_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'adress')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
