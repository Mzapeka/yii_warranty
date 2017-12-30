<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 30.12.17
 * Time: 19:08
 */

namespace backend\modules\importData\models\catalogManager;

use Countable;
use Iterator;

/**
 *Класс для хранения описания документов из b2b порталла
 * @property integer $id - идентификатор документа
 * @property integer $category_id - идентификатор категории
 * @property string $name - название
 * @property string $file_type - тип файла
 * @property string $file_size - размер файла KB
 *
 */

class B2bPortalDocument implements Iterator, Countable
{

    private $id;
    private $name;
    private $file_type;
    private $file_size;
    private $category_id;

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
     * @param int $category_id
     */
    public function setCategoryId(int $category_id): void
    {
        $this->category_id = $category_id;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string $file_type
     */
    public function setFileType(string $file_type): void
    {
        $this->file_type = $file_type;
    }

    /**
     * @param string $file_size
     */
    public function setFileSize(string $file_size): void
    {
        $this->file_size = $file_size;
    }

    public function add():void
    {
        $this->container[$this->cursor] = [
            'id' => $this->id,
            'name' => $this->name,
            'file_type' => $this->file_type,
            'file_size' => $this->file_size,
            'category_id' => $this->category_id,
        ];
        $this->next();
    }

    /**
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return B2bPortalDocument
     * @since 5.0.0
     */
    public function current():B2bPortalDocument
    {
        $this->id = $this->container[$this->cursor]['id'];
        $this->name = $this->container[$this->cursor]['name'];
        $this->file_type = $this->container[$this->cursor]['file_type'];
        $this->file_size = $this->container[$this->cursor]['file_size'];
        $this->category_id = $this->container[$this->cursor]['category_id'];
        return $this;
    }

    /**
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
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
    public function rewind()
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