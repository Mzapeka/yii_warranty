<?php
/* @var $this yii\web\View */

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\DataProviderInterface */
/* @var $category \site\entities\Catalog\Category */

use app\widgets\catalogMenu\CatalogMenu;
use yii\helpers\Html;

$this->params['breadcrumbs'][] = ['label' => 'Catalog', 'url' => ['index']];
foreach ($category->parents()->all() as $parent) {
    if (!$parent->isRoot()) {
        $this->params['breadcrumbs'][] = ['label' => $parent->name, 'url' => ['category', 'id' => $parent->id]];
    }
}
$this->params['breadcrumbs'][] = $category->name;

$this->params['active_category'] = $category;

//$this->title = 'Документы';
//$this->params['breadcrumbs'][] = $this->title;
//$this->params['breadcrumbs'][] = $category->getBreadcrumbs();
?>

<h1><?= Html::encode($this->title) ?></h1>
<div class="row">
    <div class="col-md-3">
        <div class="row">
            <?= CatalogMenu::widget([
                    'type' => CatalogMenu::TYPE_DEFAULT,
            ]) ?>
        </div>

    </div>
    <div class="col-md-9" role="main">

    </div>

</div>


<?= $this->render('_list', [
    'dataProvider' => $dataProvider
]) ?>

