<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 18.11.17
 * Time: 23:03
 */

namespace site\helpers;


use site\entities\Warranty\Warranty;
use yii\bootstrap\Html;
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

}