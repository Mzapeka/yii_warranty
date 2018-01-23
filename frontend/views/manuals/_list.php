<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 18.01.18
 * Time: 20:54
 */

/**
 * @var \site\entities\Catalog\Item $model
*/
use yii\helpers\Url;

?>


    <div class="doc-icon"><img src="<?= file_exists(Yii::getAlias('@webroot/img/'.$model->file_type.'.png'))? Url::to('/img/'.$model->file_type.'.png') : Url::to('/img/file.png')?>"></div>
    <div class="doc-info">
        <div class="load-link"><a role="button" class="btn btn-default btn-sm" href="<?=Url::to(['/manuals/document', 'id'=>$model->id])?>">Скачать</a></div>
        <div class="info-size">(<?=$model->file_type?>, <?=$model->file_size?>)</div>
    </div>
    <div class="doc-name"><a target="_blank" href="<?=Url::to(['/manuals/document', 'id'=>$model->id])?>"><?=$model->name?></a></div>
    <div class="clear">&nbsp;</div>

