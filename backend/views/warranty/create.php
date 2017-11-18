<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model site\entities\Warranty\Warranty */

$this->title = 'Create Warranty';
$this->params['breadcrumbs'][] = ['label' => 'Warranties', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="warranty-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
