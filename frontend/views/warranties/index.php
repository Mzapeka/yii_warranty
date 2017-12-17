<?php

use kartik\grid\GridView;
use kartik\widgets\DatePicker;
use site\entities\Warranty\Warranty;
use site\helpers\CustomerHelper;
use site\helpers\WarrantyHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\WarrantySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$columnSettings = array(
    [
        'class' => '\kartik\grid\SerialColumn',
        'contentOptions' => ['class' => 'kartik-sheet-style'],
        'width' => '25px',
        'headerOptions' => ['class' => 'kartik-sheet-style']
    ],
    [
        'class' => 'kartik\grid\ExpandRowColumn',
        'width' => '30px',
        'value' => function ($model, $key, $index, $column) {
            return GridView::ROW_COLLAPSED;
        },
        'detail' => function ($model, $key, $index, $column) {
            return Yii::$app->controller->renderPartial('expand-row-details', ['model' => $model]);
        },
        'headerOptions' => ['class' => 'kartik-sheet-style'],
        'expandOneOnly' => true
    ],
    //'id',
    [
        'attribute' => 'customer_id',
        'vAlign' => 'middle',
        'width' => '140px',
        'filter' => CustomerHelper::getCustomerListBelongToUser(),
        'value' => function (Warranty $model) {
            return CustomerHelper::getCustomerNameByID($model->customer_id);
        },
    ],
    [
        'attribute' => 'device_name',
        'vAlign' => 'middle',
        'width' => '120px',
    ],
    [
        'attribute' => 'part_number',
        'vAlign' => 'middle',
        'width' => '90px',
    ],
    [
        'attribute' => 'serial_number',
        'vAlign' => 'middle',
        'width' => '90px',
    ],
//    [
//        'attribute' => 'invoice_number',
//        'vAlign' => 'middle',
//        'width' => '90px',
//    ],
//    [
//        'attribute' => 'act_number',
//        'vAlign' => 'middle',
//        'width' => '60px',
//    ],
/*    [
        'attribute' => 'invoice_date',
        'vAlign' => 'middle',
        'width' => '70px',
        'format' => ['date', 'php:Y-m-d'],
        'xlFormat' => "mmm-dd-yyyy",
        'filterType' => GridView::FILTER_DATE,
        'filterWidgetOptions' => [
            'type' => DatePicker::TYPE_RANGE,
            'attribute2' => 'invoice_date_to',
            'separator' => '-',
            'pluginOptions' => [
                'todayHighlight' => true,
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd'
            ]
        ],
        'headerOptions' => ['class' => 'kv-sticky-column'],
        'contentOptions' => ['class' => 'kv-sticky-column'],
    ],*/
/*    [
        'attribute' => 'act_date',
        'vAlign' => 'middle',
        'width' => '90px',
        'format' => ['date', 'php:Y-m-d'],
        'xlFormat' => "mmm\\-dd\\, \\-yyyy",
        'filterType' => GridView::FILTER_DATE,
        'filterWidgetOptions' => [
            'type' => DatePicker::TYPE_RANGE,
            'attribute2' => 'act_date_to',
            'separator' => '-',
            'pluginOptions' => [
                'todayHighlight' => true,
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd'
            ]
        ],
        'headerOptions' => ['class' => 'kv-sticky-column'],
        'contentOptions' => ['class' => 'kv-sticky-column'],
    ],*/
    [
        'attribute' => 'invoice_date',
        'vAlign' => 'middle',
        'width' => '90px',
        'format' => ['date', 'php:Y-m-d'],
        'xlFormat' => "mmm\\-dd\\, \\-yyyy",
        'filterType' => 'kartik\daterange\DateRangePicker',

        'filterWidgetOptions' => [
            'name'=>'act_date',
            'hideInput' => false,
            'useWithAddon'=>false,
            'convertFormat'=>true,
            'presetDropdown' => false,
            'autoUpdateOnInit' => false,
            'pluginOptions'=>[
                'locale'=>['format' => 'Y-m-d'],
            ]
        ],
    ],
    [
        'attribute' => 'act_date',
        'vAlign' => 'middle',
        'width' => '90px',
        'format' => ['date', 'php:Y-m-d'],
        'xlFormat' => "mmm\\-dd\\, \\-yyyy",
        'filterType' => 'kartik\daterange\DateRangePicker',

        'filterWidgetOptions' => [
            'name'=>'act_date',
            'value' => '2018-10-04 - 2018-11-14',
            'hideInput' => false,
            'useWithAddon'=>false,
            'convertFormat'=>true,
            'presetDropdown' => false,
            'autoUpdateOnInit' => false,
            'pluginOptions'=>[
                'locale'=>['format' => 'Y-m-d'],
            ]
        ],
    ],

/*    [
        'attribute' => 'created_at',
        'vAlign' => 'middle',
        'width' => '70px',
        'format' => ['date', 'php:Y-m-d'],
        'headerOptions' => ['class' => 'kv-sticky-column'],
        'contentOptions' => ['class' => 'kv-sticky-column'],
    ],*/
    [
        'attribute' => 'status',
        'vAlign' => 'middle',
        'width' => '50px',
        'filter' => WarrantyHelper::statusList(),
        'value' => function (Warranty $model) {
            return WarrantyHelper::statusLabel($model->status);
        },
        'format' => 'raw',
    ],
    [
            'attribute' => 'warrantyValidUntil',
            'vAlign' => 'middle',
            'width' => '70px',
            'mergeHeader' => true,
            'filter' => '',
            'format' => ['date', 'php:Y-m-d'],
            'headerOptions' => ['class' => 'kv-sticky-column'],
            'contentOptions' => ['class' => 'kv-sticky-column'],
        ],

    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'dropdownOptions' => ['class' => 'pull-right'],
        'viewOptions' => ['title' => 'Детали', 'data-toggle' => 'tooltip'],
        'headerOptions' => ['class' => 'kartik-sheet-style'],
        'template' => '{view} &nbsp; {print-warranty}',
        'buttons' => [
            'print-warranty' =>     function ($url, $model) {
            return Html::a('<span class="glyphicon glyphicon-print">', Url::to($url), [
                'title' => 'Гарантийный лист',
                'data-toggle' => 'tooltip',
            ]);
        }],
        'visibleButtons' => [
            'update'=> false,
            'delete'=> false,
            'print-warranty' => true,
        ],
    ],
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'headerOptions' => ['class' => 'kartik-sheet-style'],
    ],
);

?>
<div class="warranty-index">


<?php
    try{
       echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            /*        'tableOptions'=>[
                            'style'=>'white-space: normal;',
                            'class' => 'table table-striped table-bordered table-hover table-responsive maintab'
                        ],*/
           'tableOptions' => ['class'=>'maintab' ],
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
                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], ['data-pjax' => 0, 'class' => 'btn btn-success', 'title' => 'Добавить гарантию']) . ' '.
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''], ['data-pjax' => 0, 'class' => 'btn btn-default', 'title' => 'Сбросить'])

                ],
                '{export}',
                '{toggleData}',
            ],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<i class="glyphicon glyphicon-dashboard"></i>  Гарантии',
            ],
            'persistResize' => false,
            'toggleDataOptions' => ['minCount' => 10],
            // set export properties
            'export' => [
                'fontAwesome' => true
            ],
            'columns' => $columnSettings,
        ]);
    } catch (Exception $e){
        Yii::$app->errorHandler->logException($e);
        echo 'Ошибка вывода информации: '.$e->getMessage();
    } ?>

</div>
