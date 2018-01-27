<?php

use site\services\category\CategoryImportResult;
use yii\bootstrap\Html;
use yii\helpers\Url;

/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 29.12.17
 * Time: 0:23
 */

/**
*@var array $result */

?>
<h3>Отчет по импорту документов</h3>
<p>Всего найдено: <?=$result['all']?></p>
<p>Всего импортировано: <?=$result['imported']?></p>
<p>Были импортированы ранее: <?=$result['notImported']?></p>
<hr/>
<p>Перейти на <?= Html::a('страницу документов.', Url::toRoute('/item'))?></p>
