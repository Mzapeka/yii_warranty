<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 25.11.17
 * Time: 21:51
 */
/* @var $notification array */
?>

<h3>Таблица User:</h3>
<p>Всего найдено записей: <?=$notification['user']['all']?></p>
<p>Из них загружено: <?=$notification['user']['added']?></p>
<h3>Таблица Customer:</h3>
<p>Всего найдено записей: <?=$notification['customer']['all']?></p>
<p>Из них загружено: <?=$notification['customer']['added']?></p>
<h3>Таблица Warranty:</h3>
<p>Всего найдено записей: <?=$notification['warranty']['all']?></p>
<p>Из них загружено: <?=$notification['warranty']['added']?></p>
