<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\forms\WarrantySettingsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->registerCssFile('css/site.css');

$this->title = 'Настройки гарантии';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="warranty-settings-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'layout' => "{items}",
        'itemView' => '_item',
    ]) ?>
    <?php Pjax::end(); ?>
</div>
