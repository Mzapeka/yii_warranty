<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 03.12.17
 * Time: 16:13
 */

use yii\helpers\Url;

?>

<div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
    <div class="list-group">
        <a href="<?= Url::to('customers')?>" class="list-group-item <?=$this->context->id == 'customers'?'active':''?>">Клиенты</a>
        <a href="<?= Url::to('warranties')?>" class="list-group-item <?=$this->context->id == ''?'active':''?>">Гарантии</a>
        <a href="<?= Url::to('manuals')?>" class="list-group-item <?=$this->context->id == ''?'active':''?>">Инструкции</a>
    </div>
</div><!--/span-->
