<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model site\entities\StartPageSetting\StartPageSetting */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="start-page-setting-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'icon')->widget(\sjaakp\symbolpicker\SymbolPicker::className(), [
            'icons' => \site\helpers\StartPageSettingHelper::getIconNames()
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
