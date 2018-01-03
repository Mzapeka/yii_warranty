<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 03.01.18
 * Time: 22:22
 */

namespace backend\modules\importData\models\catalogManager;


trait IteratorTreit
{
    protected $container = [];
    protected $cursor;

    public function __construct()
    {
        $this->cursor = 0;
    }

    public function add():void
    {
        $data = (array)$this;
        foreach ($data as $key => $val){
            if(!preg_match('/\*/',$key)){
                $this->container[$this->cursor][trim($key)] = $val;
            }
        }
        $this->next();
    }

    /**
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */

    public function current()
    {
        foreach ($this->container[$this->cursor] as $key => $val){
            $this->$key = $val;
        }
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