<?php

use kartik\form\ActiveForm;
use kartik\widgets\DatePicker;
use site\entities\Warranty\Warranty;
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


$this->title = 'Редактирование гарантии: '.$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Гарантии', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Гарантия № '.$warranty->id, 'url' => ['view', 'id' => $warranty->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="warranty-update">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'customer_id')->dropDownList(CustomerHelper::getCustomerNameList())->label(Warranty::labels('customer_id')) ?>
    <?= $form->field($model, 'device_name')->textInput(['maxlength' => true])->label(Warranty::labels('device_name')) ?>
    <?= $form->field($model, 'part_number')->textInput(['maxlength' => true])->label(Warranty::labels('part_number')) ?>
    <?= $form->field($model, 'serial_number')->textInput(['maxlength' => true])->label(Warranty::labels('serial_number')) ?>
    <?= $form->field($model, 'invoice_number')->textInput(['maxlength' => true])->label(Warranty::labels('invoice_number')) ?>
    <?= $form->field($model, 'act_number')->textInput(['maxlength' => true])->label(Warranty::labels('act_number')) ?>
    <?= $form->field($model, 'invoice_date')->widget(DatePicker::className(),[
        'type' => DatePicker::TYPE_COMPONENT_APPEND,
        'language' => 'ru',
        'pluginOptions' => [
            'todayHighlight' => true,
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd',
        ],
    ])->label(Warranty::labels('invoice_date')) ?>
    <?= $form->field($model, 'act_date')->widget(DatePicker::className(),[
        'type' => DatePicker::TYPE_COMPONENT_APPEND,
        'language' => 'ru',
        'pluginOptions' => [
            'todayHighlight' => true,
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd',
        ],
    ])->label(Warranty::labels('act_date')) ?>
    <?= $form->field($model, 'status')->dropDownList(WarrantyHelper::statusList())->label(Warranty::labels('status')) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
