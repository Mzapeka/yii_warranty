<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 30.12.17
 * Time: 17:18
 */

use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $query Category */

$this->title = 'Импорт данных каталога';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class=" catalog-index">

    <div class="box">
        <div class="box-body">
            <p>
                <?= Html::a('Импортировать категории', Url::to('import-catalog/import-category'), ['class' => 'btn btn-success']) ?>
                <?= Html::a('Импортировать документы', Url::to('import-catalog/import-documents'), ['class' => 'btn btn-success']) ?>
            </p>
        </div>
    </div>

</div>