<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 18.11.17
 * Time: 23:03
 */

namespace site\helpers;


use DateInterval;
use site\entities\Warranty\Warranty;
use site\entities\Warranty\WarrantySettings;
use Yii;
use yii\bootstrap\Html;
use yii\db\Exception;
use yii\helpers\ArrayHelper;

class WarrantySettingsHelper
{
    public static function loadParamsFromDb(){
        //кешируем данные из базы до следующего изменения значений в базе
        $params = Yii::$app->cache->getOrSet('warranty-settings', function (){
                return ArrayHelper::map(WarrantySettings::find()->select(['key', 'value'])->asArray()->all(),'key','value');
        }, 1000);

        Yii::$app->params = ArrayHelper::merge(Yii::$app->params, $params);
        return true;
    }

}