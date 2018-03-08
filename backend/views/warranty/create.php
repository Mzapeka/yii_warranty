<?php

use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use site\entities\Warranty\Warranty;
use site\helpers\CustomerHelper;
use site\helpers\WarrantyHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model site\entities\Warranty\Warranty */

$this->title = 'Новая гарантия';
$this->params['breadcrumbs'][] = ['label' => 'Гарантии', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

/*
if(!empty($model->invoice_date)){
    $model->invoice_date = date('dd-M-yyyy', $model->invoice_date);
}
if(!empty($model->act_date)){
    $model->act_date = date('dd-M-yyyy', $model->act_date);
}*/
?>
<div class="warranty-create">

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
        'separator' => '-',
        'pluginOptions' => [
            'todayHighlight' => true,
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd',
        ],
    ])->label(Warranty::labels('invoice_date'))  ?>
    <?= $form->field($model, 'act_date')->widget(DatePicker::className(),[
        'type' => DatePicker::TYPE_COMPONENT_APPEND,
        'language' => 'ru',
        'separator' => '-',
        'pluginOptions' => [
            'todayHighlight' => true,
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd',
        ],
    ])->label(Warranty::labels('act_date')) ?>

    <?= $form->field($model, 'production_date')->widget(DatePicker::className(),[
        'type' => DatePicker::TYPE_COMPONENT_APPEND,
        'language' => 'ru',
        'separator' => '-',
        'pluginOptions' => [
            'todayHighlight' => true,
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd',
        ],
    ])->label(Warranty::labels('production_date')) ?>
    <?= $form->field($model, 'status')->dropDownList(WarrantyHelper::statusList())->label(Warranty::labels('status')) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
