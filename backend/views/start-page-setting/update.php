<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model site\entities\StartPageSetting\StartPageSetting */

$this->title = 'Update Start Page Setting: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Start Page Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $setting->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="start-page-setting-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
