<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 28.12.17
 * Time: 21:33
 */

namespace backend\modules\catalogManager\models;

/**
*Структура для хранения категории из b2b порталла
 * @property integer $id - идентификатор категории
 * @property string $name - имя
 * @property integer $level - уровень меню
 *
 */

class B2bPortalCategory
{
    public $id;
    public $name;
    public $level;

}