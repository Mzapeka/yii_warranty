<?php

use site\entities\Warranty\Warranty;
use site\helpers\WarrantyHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\forms\WarrantySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Гарантии';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="warranty-index">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Зарегистрировать гарантию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            'customer_id',
            'device_name',
            'part_number',
            'serial_number',
            'invoice_number',
            'act_number',
            'invoice_date:date',
            'act_date:date',
            'created_at:date',
            //'updated_at:date',
            [
                'attribute' => 'status',
                'filter' => WarrantyHelper::statusList(),
                'value' => function (Warranty $model) {
                    return WarrantyHelper::statusLabel($model->status);
                },
                'format' => 'raw',
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
