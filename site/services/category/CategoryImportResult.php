<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 28.12.17
 * Time: 23:57
 */

namespace site\services\category;


class CategoryImportResult
{
    private $totalCategoriesOnPortal = 0;
    private $totalCategoriesImported = 0;
    private $error = null;

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param mixed $error
     */
    public function setError($error): void
    {
        $this->error = $error;
    }
    /**
     * @return integer
     */
    public function getTotalCategoriesOnPortal(): int
    {
        return $this->totalCategoriesOnPortal;
    }

    /**
     * @param int $totalCategoriesOnPortal
     */
    public function setTotalCategoriesOnPortal($totalCategoriesOnPortal): void
    {
        $this->totalCategoriesOnPortal = $totalCategoriesOnPortal;
    }

    public function incrementTotalCategoriesOnPortal(): void
    {
        $this->totalCategoriesOnPortal++;
    }

    /**
     * @return int
     */
    public function getTotalCategoriesImported():int
    {
        return $this->totalCategoriesImported;
    }

    /**
     * @param int $totalCategoriesImported
     */
    public function setTotalCategoriesImported($totalCategoriesImported): void
    {
        $this->totalCategoriesImported = $totalCategoriesImported;
    }

    public function incrementTotalCategoriesImported(): void
    {
        $this->totalCategoriesImported++;
    }

    /**
     * @return int
     */
    public function getTotalCategoriesNotImported():int
    {
        return $this->totalCategoriesOnPortal - $this->totalCategoriesImported;
    }


}