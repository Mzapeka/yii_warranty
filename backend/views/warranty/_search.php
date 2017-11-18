<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\forms\WarrantySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="warranty-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'customer_id') ?>

    <?= $form->field($model, 'device_name') ?>

    <?= $form->field($model, 'part_number') ?>

    <?= $form->field($model, 'serial_number') ?>

    <?php // echo $form->field($model, 'invoice_number') ?>

    <?php // echo $form->field($model, 'act_number') ?>

    <?php // echo $form->field($model, 'invoice_date') ?>

    <?php // echo $form->field($model, 'act_date') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
