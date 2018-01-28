<?php
/* @var $this yii\web\View */

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\DataProviderInterface */
/* @var $category \site\entities\Catalog\Category */

use app\widgets\catalogMenu\CatalogMenu;
use yii\helpers\Html;
use yii\widgets\ListView;

$this->params['breadcrumbs'][] = ['label' => 'Документы', 'url' => ['index']];

if($category){
    foreach ($category->parents()->all() as $parent) {
        if (!$parent->isRoot()) {
            $this->params['breadcrumbs'][] = ['label' => $parent->name, 'url' => ['category', 'id' => $parent->id]];
        }
    }
    $this->params['breadcrumbs'][] = $category->name;
}

?>

<h1><?= Html::encode($this->title) ?></h1>
<div class="row">
    <div class="col-md-3">
        <div class="row">
            <?= CatalogMenu::widget([
                    'type' => CatalogMenu::TYPE_DEFAULT,
                    'activeCategory' => $category,
                'encodeLabels'=>false,
                'activateParents' => true,
                //'activateItems' => false,
                'heading' => '<i class="glyphicon glyphicon-book"></i> Разделы',
            ]) ?>
        </div>

    </div>
    <div class="col-md-9" role="main">
        <?= $dataProvider? ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_list',
            'itemOptions' => [
                'tag' => 'div',
                'class' => 'docs-item',
            ],
            'layout' => "{pager}\n{summary}\n{items}\n{pager}",
            'pager' => [
                'firstPageLabel' => 'Первая',
                'lastPageLabel' => 'Последняя',
                'nextPageLabel' => 'Следующая',
                'prevPageLabel' => 'Предыдущая',
                'maxButtonCount' => 5,
            ],
            'emptyText' => 'Документы не найдены',
            'emptyTextOptions' => [
                'tag' => 'p'
            ],

        ]): ''?>

    </div>

</div>




