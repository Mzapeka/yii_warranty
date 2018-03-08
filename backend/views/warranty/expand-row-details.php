<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 13.12.17
 * Time: 20:21
 */

use site\helpers\UserHelper;

/**
 *
*/

?>

<p>Диллер - <?= UserHelper::getUserNameByCustomerId($model->customer_id)?></p>
<p>Дата создания - <?= Yii::$app->formatter->asDate($model->created_at)?></p>
<p>Дата редактирования - <?= Yii::$app->formatter->asDate($model->updated_at)?></p>


