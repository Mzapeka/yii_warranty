<?php

use kartik\tree\TreeViewInput;
use kartik\widgets\FileInput;
use site\entities\Catalog\Category;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model site\entities\Catalog\Item */

$this->title = 'Новый документ';
$this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название документа') ?>

    <?= $form->field($model, 'category_id')->widget(TreeViewInput::className(),[
        'query' => Category::find()->addOrderBy('root, lft'),
        'headingOptions' => ['label' => 'Выберите категорию'],
        'rootOptions' => ['label'=>'<i class="fa fa-tree text-success"></i>'],
        'fontAwesome' => true,
        'asDropdown' => true,
        'multiple' => false,
        'options' => ['disabled' => false]
    ])->label('Категория') ?>

    <?= $form->field($model, 'disabled')->dropDownList(['0'=>'Активный', '1'=>'Не активный'])->label('Флаг активности')  ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true])->label('Описание')  ?>

    <?= $form->field($model, 'document')->widget(FileInput::className(),[
        'name' => 'attachments',
        'options' => ['multiple' => false],
        'pluginOptions' => ['previewFileType' => 'any']
    ])->label('Файл документа') ;?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
