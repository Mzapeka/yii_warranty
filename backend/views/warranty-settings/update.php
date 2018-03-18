<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model site\entities\Warranty\WarrantySettings */
/* @var $form \site\forms\warranty\WarrantySettingsEditForm*/

$this->title = 'Редактирование настройки: '.$model->title;
$this->params['breadcrumbs'][] = ['label' => 'Warranty Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->key]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="warranty-settings-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="warranty-settings-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
