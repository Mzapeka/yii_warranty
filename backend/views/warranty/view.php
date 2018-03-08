<?php

use site\entities\Warranty\Warranty;
use site\helpers\CustomerHelper;
use site\helpers\WarrantyHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model site\entities\Warranty\Warranty */

$this->title = "Гарантия № ".$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Гарантии', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="warranty-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'customer_id',
                'label' => 'Клиент',
                'value' => function (Warranty $model) {
                    return CustomerHelper::getCustomerNameByID($model->customer_id);
                },
            ],
            'device_name',
            'part_number',
            'serial_number',
            'invoice_number',
            'act_number',
            'invoice_date:date',
            'act_date:date',
            'production_date:date',
            'created_at:datetime',
            'updated_at:datetime',
            [
                'attribute' => 'status',
                'filter' => WarrantyHelper::statusList(),
                'value' => function (Warranty $model) {
                    return WarrantyHelper::statusLabel($model->status);
                },
                'format' => 'raw',
            ],
        ],
    ]) ?>

</div>
