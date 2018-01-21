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
    $categoryChildren = $category->children(1)->all();
    if ($categoryChildren): ?>
        <ul class="nav bs-docs-sidenav">
            <?php foreach ($categoryChildren as $child): ?>
                <?php
                    $spacer = '';
/*                    for($i = 1; $i < $child->lvl; $i++){
                        $spacer .= "&#8212;&#8212;";
                    }*/

                ?>
            <li>
                <a href="<?= Html::encode(Url::to(['/manuals/category', 'id' => $child->id])) ?>"><?= $spacer.Html::encode($child->name) ?></a> &nbsp;
            </li>
            <?php endforeach; ?>
        </ul>
<?php endif;
?>


