<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 03.12.17
 * Time: 17:24
 */

namespace frontend\views\layouts\manager;

use yii\web\AssetBundle;


class ManagerAsset extends AssetBundle
{
    public $sourcePath = '@app/views/layouts/manager/assets';

    public $css = [
        'css/offcanvas.css',
    ];
    public $js = [
        'js/offcanvas.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}