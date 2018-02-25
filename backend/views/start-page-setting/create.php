<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model site\entities\StartPageSetting\StartPageSetting */

$this->title = 'Create Start Page Setting';
$this->params['breadcrumbs'][] = ['label' => 'Start Page Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="start-page-setting-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
