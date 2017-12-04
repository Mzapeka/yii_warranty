<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 03.12.17
 * Time: 15:54
 */

use frontend\views\layouts\manager\ManagerAsset;


/* @var $this \yii\web\View */
/* @var $content string */

ManagerAsset::register($this);
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@app/views/layouts/manager/assets');

?>

<?php $this->beginContent('@app/views/layouts/main.php'); ?>


<div class="container">
    <div class="row row-offcanvas row-offcanvas-right site-index">

        <div class="col-xs-12 col-sm-9">
            <p class="pull-right visible-xs">
                <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
            </p>

            <?= $content ?>

        </div><!--/span-->

        <?= $this->render(
            'menu'
            //['content' => $content, 'directoryAsset' => $directoryAsset]
        ) ?>


    </div><!--/row-->
</div>


<?php $this->endContent(); ?>

