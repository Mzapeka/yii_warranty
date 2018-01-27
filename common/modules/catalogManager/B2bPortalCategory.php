<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 28.12.17
 * Time: 21:33
 */
namespace common\modules\catalogManager;;
use Countable;
use Iterator;


/**
*Класс для хранения категории из b2b порталла
 * @property integer $id - идентификатор категории
 * @property string $name - имя
 * @property integer $level - уровень меню
 *
 */

class B2bPortalCategory implements Iterator, Countable
{
    use IteratorTreit;

    public $id;
    public $name;
    public $level;


    /**
     * @param int $id
     */
    public function setId(int $id): void
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
     * @param int $level
     */
    public function setLevel(int $level): void
    {
        $this->level = $level;
    }

}