<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model site\entities\Warranty\Warranty */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Warranties', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="warranty-view">

    <h1><?= Html::encode($this->title) ?></h1>

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
            'customer_id',
            'device_name',
            'part_number',
            'serial_number',
            'invoice_number',
            'act_number',
            'invoice_date',
            'act_date',
            'created_at',
            'updated_at',
            'status',
        ],
    ]) ?>

</div>
