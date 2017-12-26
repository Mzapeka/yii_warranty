<?php


use kartik\tree\Module;
use kartik\tree\TreeView;
use app\modules\catalogManager\models\TreeBuilder;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\forms\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Каталог';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class=" catalog-index">

    <div class="box">
        <div class="box-body">
            <?= TreeView::widget(array(
                // single query fetch to render the tree
                // use the Product model you have in the previous step
                'query' => TreeBuilder::find()->addOrderBy('root, lft'),
                'headingOptions' => ['label' => 'Store'],
                'rootOptions' => ['label'=>'<span class="text-primary">Категории</span>'],
                'topRootAsHeading' => true, // this will override the headingOptions
                'fontAwesome' => true,
                'isAdmin' => true,
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
                'softDelete' => true,
                'cacheSettings' => ['enableCache' => true]
            )); ?>
        </div>
    </div>

    <p>
        <?= Html::a('Импортировать категории', Url::to('category/catalog-import'), ['class' => 'btn btn-success']) ?>
    </p>

</div>
