<?php

use site\helpers\UserHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model site\entities\Customer\Customer */

$this->title = 'Create Customer';
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-create">

    <h1><?= Html::encode($this->title) ?></h1>


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
