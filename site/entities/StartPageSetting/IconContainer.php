<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 28.12.17
 * Time: 21:33
 */
namespace site\entities\StartPageSetting;

use Countable;
use Iterator;
use site\helpers\common\IteratorTreit;


/**
*Класс для хранения иконок
 * @property string $id - уникальное id иконки
 * @property string $name - имя иконки
 * @property string $category - категория
 *
 */

class IconContainer implements Iterator, Countable
{
    use IteratorTreit;

    public $id;
    public $name;
    public $category;


    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string $category
     */
    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

}