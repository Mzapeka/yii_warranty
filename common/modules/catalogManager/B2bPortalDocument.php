<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 30.12.17
 * Time: 19:08
 */

namespace common\modules\catalogManager;

use Countable;
use Iterator;
use site\helpers\common\IteratorTreit;

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
    use IteratorTreit;

    public $id;
    public $name;
    public $file_type;
    public $file_size;
    public $category_id;


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
}