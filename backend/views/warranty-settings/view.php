<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model site\entities\Warranty\WarrantySettings */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Warranty Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="warranty-settings-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'key',
            'title',
            'value',
            'unit',
            'description',
        ],
    ]) ?>

</div>
