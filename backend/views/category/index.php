<?php


use kartik\tree\Module;
use kartik\tree\TreeView;
use site\entities\Catalog\Category;
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $query Category */

$this->title = 'Каталог';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class=" catalog-index">

    <div class="box">
        <div class="box-body">
            <?= TreeView::widget(array(
                'query' => $query,
                'headingOptions' => ['label' => 'Store'],
                'rootOptions' => ['label'=>'<span class="text-primary">Категории</span>'],
                'topRootAsHeading' => true, // this will override the headingOptions
                'fontAwesome' => true,
                'isAdmin' => true,
                'showInactive' => true,
                'iconEditSettings'=> [
                    'show' => 'list',
                    'listData' => [
                        'folder' => 'Folder',
                        'file' => 'File',
                        'mobile' => 'Phone',
                        'bell' => 'Bell',
                        'heartbeat' => 'Heartbeat',
                    ]
                ],
                'nodeAddlViews' => [
                    Module::VIEW_PART_2 => '@backend/views/category/_tree_part2'
                ],
                'softDelete' => false,
                'cacheSettings' => ['enableCache' => true]
            )); ?>
        </div>
    </div>

    <p>
        <?= Html::a('Импортировать категории', Url::to('/category/catalog-import'), ['class' => 'btn btn-success']) ?>
    </p>

</div>
