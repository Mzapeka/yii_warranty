<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 28.12.17
 * Time: 21:33
 */

namespace backend\modules\catalogManager\models;
use Countable;
use \Iterator;

/**
*Структура для хранения категории из b2b порталла
 * @property integer $id - идентификатор категории
 * @property string $name - имя
 * @property integer $level - уровень меню
 *
 */

class B2bPortalCategory implements Iterator, Countable
{
    private $id;
    private $name;
    private $level;

    protected $container = [];
    protected $cursor;

    public function __construct()
    {
        $this->cursor = 0;
    }

    public function __get($name)
    {
        return $this->$name;
    }

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

    public function add():void
    {
        $this->container[$this->cursor] = [
            'id' => $this->id,
            'name' => $this->name,
            'level' => $this->level
        ];
        $this->next();
    }

    /**
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */

    public function current():B2bPortalCategory
    {
        $this->id = $this->container[$this->cursor]['id'];
        $this->name = $this->container[$this->cursor]['name'];
        $this->level = $this->container[$this->cursor]['level'];
        return $this;
    }

    /**
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next():void
    {
        ++$this->cursor;
    }

    /**
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->cursor;
    }

    /**
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return isset($this->container[$this->cursor]);
    }

    /**
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind():void
    {
        $this->cursor = 0;
    }

    /**
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return count($this->container);
    }
}