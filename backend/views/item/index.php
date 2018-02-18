<?php

use kartik\grid\GridView;
use site\entities\Catalog\Category;
use site\entities\Catalog\Item;
use site\helpers\CategoryHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Items';
$this->params['breadcrumbs'][] = $this->title;

$columnSettings = array(
    [
        'class' => '\kartik\grid\SerialColumn',
        'contentOptions' => ['class' => 'kartik-sheet-style'],
        'width' => '25px',
        'headerOptions' => ['class' => 'kartik-sheet-style']
    ],

    [
        'attribute' => 'category_id',
        'label' => 'Категория',
        'vAlign' => 'middle',
        'width' => '140px',
        'filterType' => '\kartik\tree\TreeViewInput',
        'filterWidgetOptions' => [
            'query' => Category::find()->addOrderBy('root, lft'),
            'rootOptions' => ['label'=>'<i class="fa fa-tree text-success"></i>'],
            'fontAwesome' => true,
            'asDropdown' => true,
            'multiple' => false,
            'options' => ['disabled' => false]
        ],
        'value' => function (Item $model) {
            return CategoryHelper::getCategoryNameById($model->category_id);
        },
    ],
    [
        'attribute' => 'name',
        'vAlign' => 'middle',
        'width' => '150px',
    ],
    [
        'attribute' => 'file_type',
        'vAlign' => 'middle',
        'width' => '90px',
    ],
    [
        'attribute' => 'file_size',
        'vAlign' => 'middle',
        'width' => '90px',
    ],
    [
        'attribute' => 'description',
        'vAlign' => 'middle',
        'width' => '90px',
    ],
    [
        'attribute' => 'file_name',
        'vAlign' => 'middle',
        'width' => '90px',
    ],
    [
        'attribute' => 'disabled',
        'label' => 'Блок',
        'value' => function (Item $model) {
            return Yii::$app->formatter->asBoolean($model->disabled);
        },
        'vAlign' => 'middle',
        'width' => '30px',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'dropdownOptions' => ['class' => 'pull-right'],
        'viewOptions' => ['title' => 'Детали', 'data-toggle' => 'tooltip'],
        'headerOptions' => ['class' => 'kartik-sheet-style'],
    ],

);
?>
<div class="item-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $columnSettings,
        'tableOptions' => ['class' => 'maintab'],
        'bordered' => true,
        'striped' => true,
        'condensed' => true,
        'responsive' => true,
        'responsiveWrap' => false,
        'hover' => true,
        'perfectScrollbar' => true,
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
        'pjax' => true,

        'toolbar' =>  [
            ['content' =>
                Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], ['data-pjax' => 0, 'class' => 'btn btn-success', 'title' => 'Добавить документ']) . ' '.
                Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''], ['data-pjax' => 0, 'class' => 'btn btn-default', 'title' => 'Сбросить'])

            ],
            '{export}',
            '{toggleData}',
        ],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<i class="glyphicon glyphicon-dashboard"></i>  Документы',
        ],
        'persistResize' => false,
        'toggleDataOptions' => ['minCount' => 10],
        'export' => [
            'fontAwesome' => true
        ],

    ]); ?>

</div>
