<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model site\entities\Catalog\Item */

$this->title = 'Create Item';
$this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_id')->textInput() ?>

    <?= $form->field($model, 'disabled')->textInput() ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'document')->widget(\kartik\widgets\FileInput::className(),[
        'name' => 'attachments',
        'options' => ['multiple' => false],
        'pluginOptions' => ['previewFileType' => 'any']
    ]);?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
