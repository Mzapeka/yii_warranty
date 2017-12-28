<?php

use site\services\category\CategoryImportResult;
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 29.12.17
 * Time: 0:23
 */

/**
*@var CategoryImportResult $result */

?>
<h3>Отчет по импорту категорий</h3>
<p>Всего найдено: <?=$result->getTotalCategoriesOnPortal()?></p>
<p>Всего импортировано: <?=$result->getTotalCategoriesImported()?></p>
<p>Были импортированы ранее: <?=$result->getTotalCategoriesNotImported()?></p>
