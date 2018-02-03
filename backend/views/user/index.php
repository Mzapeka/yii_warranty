<?php

use kartik\date\DatePicker;
use kartik\grid\GridView;
use site\access\Rbac;
use site\entities\User\User;
use site\helpers\UserHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\forms\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;

$dataColumns = [
    [
        'class' => '\kartik\grid\SerialColumn',
        'contentOptions' => ['class' => 'kartik-sheet-style'],
        'width' => '25px',
        'headerOptions' => ['class' => 'kartik-sheet-style']
    ],

    //'id',
    [
        'attribute' => 'username',
        'vAlign' => 'middle',
        'width' => '120px',
        'value' => function (User $model) {
            return Html::a(Html::encode($model->username), ['view', 'id' => $model->id]);
        },
        'format' => 'raw',
    ],
    //'email:email',
    [
        'attribute' => 'status',
        'vAlign' => 'middle',
        'width' => '50px',
        'filter' => UserHelper::statusList(),
        'value' => function (User $model) {
            return UserHelper::statusLabel($model->status);
        },
        'format' => 'raw',
    ],
    [
        'attribute' => 'company',
        'vAlign' => 'middle',
        'width' => '70px',
        'headerOptions' => ['class' => 'kv-sticky-column'],
        'contentOptions' => ['class' => 'kv-sticky-column'],
    ],
    [
        'attribute' => 'adress',
        'vAlign' => 'middle',
        'width' => '70px',
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
        'attribute' => 'group',
        'vAlign' => 'middle',
        'width' => '70px',
        'filter' => $searchModel->rolesList(),
        'value' => function(User $model){
            return UserHelper::groupLabel($model->group);
        },
        'format' => 'raw',
    ],
    /*    [
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
            'attribute' => 'created_at',
            'filter' => DatePicker::widget([
                'model' => $searchModel,
                'attribute' => 'date_from',
                'attribute2' => 'date_to',
                'type' => DatePicker::TYPE_RANGE,
                'separator' => '-',
                'pluginOptions' => [
                    'todayHighlight' => true,
                    'autoclose'=>true,
                    'format' => 'yyyy-mm-dd',
                ],
            ]),
            'format' => 'datetime',
        ],*/
    //'updated_at',

    ////'auth_key',
    //'password_hash',
    //'password_reset_token',

    // 'email_confirm_token:email',

    ['class' => 'kartik\grid\ActionColumn'],
];
?>
<div class="user-index">

    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => $dataColumns,
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
                    'heading' => '<i class="glyphicon glyphicon-briefcase"></i>  Пользователи',
                ],
                'persistResize' => false,
                'toggleDataOptions' => ['minCount' => 10],
                // set export properties
                'export' => [
                    'fontAwesome' => true
                ],

            ]); ?>
        </div>
    </div>
</div>
