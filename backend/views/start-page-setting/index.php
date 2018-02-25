<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\forms\StartPageSettingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->registerCssFile('css/symbol-colors.css');

$this->title = 'Start Page Settings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="start-page-setting-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Start Page Setting', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'url:url',
            [
                'attribute' => 'icon',
                'value' => function ($data) {
                    return '<i class="fa '.$data->icon.' fa-3x"></i>';
                },
                'format' => 'raw'
            ],
            'created_at:datetime',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
