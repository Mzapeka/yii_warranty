<?php
use kartik\date\DatePicker;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\forms\CustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customers';
//$this->params['breadcrumbs'][] = $this->title;

$columnsSettings = [
    [
        'class' => '\kartik\grid\SerialColumn',
        'contentOptions' => ['class' => 'kartik-sheet-style'],
        'width' => '25px',
        'headerOptions' => ['class' => 'kartik-sheet-style']
    ],

    [
        'attribute' => 'customer_name',
        'vAlign' => 'middle',
        'width' => '120px',
    ],
    //'id',
    //'dealer_id',
    [
        'attribute' => 'email',
        'vAlign' => 'middle',
        'width' => '70px',
        'format' => 'email',
        'headerOptions' => ['class' => 'kv-sticky-column'],
        'contentOptions' => ['class' => 'kv-sticky-column'],
    ],

    [
        'attribute' => 'created_at',
        'vAlign' => 'middle',
        'width' => '90px',
        'filterType' => GridView::FILTER_DATE,
        'filterWidgetOptions' => [
            'attribute' => 'date_from',
            'attribute2' => 'date_to',
            'type' => DatePicker::TYPE_RANGE,
            'separator' => '-',
            'pluginOptions' => [
                'todayHighlight' => true,
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd',
            ],
        ],
        'format' => ['date', 'php:Y-m-d'],
        'headerOptions' => ['class' => 'kv-sticky-column'],
        'contentOptions' => ['class' => 'kv-sticky-column'],
    ],

    [
        'attribute' => 'adress',
        'vAlign' => 'middle',
        'width' => '250px',
        'headerOptions' => ['class' => 'kv-sticky-column'],
        'contentOptions' => ['class' => 'kv-sticky-column'],
    ],
    [
        'attribute' => 'phone',
        'vAlign' => 'middle',
        'width' => '70px',
        'headerOptions' => ['class' => 'kv-sticky-column'],
        'contentOptions' => ['class' => 'kv-sticky-column'],
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => true,
        'dropdownOptions' => ['class' => 'pull-right'],
        //'urlCreator' => function($action, $model, $key, $index) { return '#'; },
        'viewOptions' => ['title' => 'Детали', 'data-toggle' => 'tooltip'],
        'updateOptions' => ['title' => 'This will launch the book update page. Disabled for this demo!', 'data-toggle' => 'tooltip'],
        'deleteOptions' => ['title' => 'This will launch the book delete action. Disabled for this demo!', 'data-toggle' => 'tooltip'],
        'headerOptions' => ['class' => 'kartik-sheet-style'],
    ],
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'headerOptions' => ['class' => 'kartik-sheet-style'],
    ],
]

?>
<div class="customer-index">

    <?php
        try {
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
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
                'pjax' => true, // pjax is set to always true for this demo
                // set your toolbar
                'toolbar' => [
                    ['content' =>
                        Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], ['data-pjax' => 0, 'class' => 'btn btn-success', 'title' => 'Добавить клиента']) . ' ' .
                        Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''], ['data-pjax' => 0, 'class' => 'btn btn-default', 'title' => 'Сбросить'])

                    ],
                    '{export}',
                    '{toggleData}',
                ],
                'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => '<i class="glyphicon glyphicon-briefcase"></i>  Клиенты',
                ],
                'persistResize' => false,
                'toggleDataOptions' => ['minCount' => 10],
                // set export properties
                'export' => [
                    'fontAwesome' => true
                ],
                'columns' => $columnsSettings,
            ]);
        }catch (Exception $e){
            Yii::$app->errorHandler->logException($e);
            echo 'Ошибка вывода информации: ';
        }

    ?>

</div>