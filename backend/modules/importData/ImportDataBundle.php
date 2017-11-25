<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 25.11.17
 * Time: 15:05
 */

namespace app\modules\importData;


use yii\web\AssetBundle;

class ImportDataBundle extends AssetBundle
{
    public $sourcePath = '@app/modules/importData/assets';

    // путь к JS файлам относительно sourcePath
    public $js = [
        'js/importdata.js'
    ];

    // путь к CSS файлам относительно sourcePath
    public $css = [
        'css/importdata.css'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset'
    ];
}