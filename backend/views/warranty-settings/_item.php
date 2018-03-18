<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 18.03.18
 * Time: 15:04
 */

use kartik\editable\Editable;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \site\entities\Warranty\WarrantySettings $model
 */
?>


<div class="warranty-settings-item">
    <?=Html::a(Html::encode($model->title), ['view', 'id' => $model->id], [
        'data-toggle'=>"tooltip",
        'title'=>$model->description
    ])?> -
    <?php
        Editable::begin([
            'model'=>$model,
            'name' => $model->key,
            'attribute' => 'value',
            'header' => 'Значение',
            'asPopover' => true,
            'format' => Editable::FORMAT_BUTTON,
            'ajaxSettings'=>[
                'url' => Url::to(['update', 'id'=>$model->id])
            ],
            'options' => [
                    'id' => $model->key,
            ],
        ]);
        Editable::end();
    ?>
    <?=$model->unit?>
</div>


<div class="clear">&nbsp;</div>