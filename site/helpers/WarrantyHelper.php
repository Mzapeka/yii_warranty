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
use Yii;
use yii\bootstrap\Html;
use yii\db\Exception;
use yii\helpers\ArrayHelper;

class WarrantyHelper
{
    public static function statusList(): array
    {
        return [
            Warranty::STATUS_WAIT => 'Wait',
            Warranty::STATUS_ACTIVE => 'Active',
        ];
    }

    public static function statusLabelArray()
    {
        $arrayWithTag = [];
        foreach (self::statusList() as $status => $name){
            $arrayWithTag[$status] = self::statusLabel($status);
        }
        return $arrayWithTag;
    }

    public static function statusLabel($status): string
    {
        switch ($status) {
            case Warranty::STATUS_WAIT:
                $class = 'label label-default';
                break;
            case Warranty::STATUS_ACTIVE:
                $class = 'label label-success';
                break;
            default:
                $class = 'label label-default';
        }

        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $class,
        ]);
    }

    public static function statusName($status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function isWarrantyBelongToUser(int $warrantyId): bool
    {
            $warranty = Warranty::findOne($warrantyId);
            if($warranty){
                return $warranty->getUsers()->one()->id == Yii::$app->getUser()->id;
            }
            return false;
    }

    public static function getMinTimeInvoiceReg(): int
    {
        $date = new \DateTime();
        $interval = DateInterval::createFromDateString('-'.Yii::$app->params['minTimeInvoiceReg'].' month');
        $date->add($interval);
        return $date->getTimestamp();
    }

    public static function getMaxTimeActReg(int $invoiceTime = null): int
    {
        $date = new \DateTime();
        if($invoiceTime){
            $date->setTimestamp($invoiceTime);
        }
        $interval = DateInterval::createFromDateString(Yii::$app->params['maxTimeActReg'].' month');
        $date->add($interval);
        return $date->getTimestamp();
    }

}