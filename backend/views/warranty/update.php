<?php

use kartik\form\ActiveForm;
use kartik\widgets\DatePicker;
use site\helpers\CustomerHelper;
use site\helpers\WarrantyHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model site\entities\Warranty\Warranty */
/* @var $warranty site\forms\warranty\WarrantyEditForm */


if(!empty($model->invoice_date)){
    $model->invoice_date = date('Y-m-d', $model->invoice_date);
}
if(!empty($model->act_date)){
    $model->act_date = date('Y-m-d', $model->act_date);
}

$this->title = 'Update Warranty: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Warranties', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $warranty->id, 'url' => ['view', 'id' => $warranty->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="warranty-update">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'customer_id')->dropDownList(CustomerHelper::getCustomerNameList()) ?>
    <?= $form->field($model, 'device_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'part_number')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'serial_number')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'invoice_number')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'act_number')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'invoice_date')->widget(DatePicker::className(),[
        'type' => DatePicker::TYPE_COMPONENT_APPEND,
        'language' => 'ru',
        'pluginOptions' => [
            'todayHighlight' => true,
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd',
        ],
    ]) ?>
    <?= $form->field($model, 'act_date')->widget(DatePicker::className(),[
        'type' => DatePicker::TYPE_COMPONENT_APPEND,
        'language' => 'ru',
        'pluginOptions' => [
            'todayHighlight' => true,
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd',
        ],
    ]) ?>
    <?= $form->field($model, 'status')->dropDownList(WarrantyHelper::statusList()) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
