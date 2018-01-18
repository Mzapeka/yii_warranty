<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 18.01.18
 * Time: 20:54
 */

/* @var $category Category */

use dmstr\widgets\Menu;
use site\entities\Catalog\Category;
use yii\helpers\Html;
use yii\helpers\Url;
?>

<?php
    $categoryChildren = $category->children()->all();
    if ($categoryChildren): ?>
        <div class="panel panel-default">
            <div class="panel-body">
                <?php foreach ($categoryChildren as $child): ?>
                <?php //var_dump($child)?>
                    <a href="<?= Html::encode(Url::to(['/manuals/category', 'id' => $child->id])) ?>"><?= Html::encode($child->name) ?></a> &nbsp;
                <?php endforeach; ?>
            </div>
        </div>
<?php endif;
?>


