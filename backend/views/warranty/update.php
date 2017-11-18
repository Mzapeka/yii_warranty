<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model site\entities\Warranty\Warranty */

$this->title = 'Update Warranty: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Warranties', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="warranty-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
