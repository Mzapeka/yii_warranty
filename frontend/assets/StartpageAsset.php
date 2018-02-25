<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * startpage frontend application asset bundle.
 */
class StartpageAsset extends AssetBundle
{
    public $sourcePath = '@vendor/fortawesome/font-awesome';

    public $css = [
        'css/font-awesome.css',
        'css/symbol-colors.css'
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'frontend\assets\AppAsset',
    ];

}
