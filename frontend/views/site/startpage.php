<?php

/* @var $this yii\web\View */

use frontend\assets\StartpageAsset;
use site\entities\StartPageSetting\StartPageSetting;
use yii\data\ActiveDataProvider;
use yii\widgets\ListView;

$this->registerAssetBundle(StartpageAsset::className());

$dataProvider = new ActiveDataProvider([
    'query' => StartPageSetting::find(),
    'pagination' => [
        'pageSize' => 50,
    ],
]);

?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <?= $dataProvider? ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => 'linkView',
                'emptyText' => 'Добро пожаловать!',
                'emptyTextOptions' => [
                    'tag' => 'p'
                ],
                'layout' => "{items}",
            ]): ''?>
       </div>

    </div>
</div>



