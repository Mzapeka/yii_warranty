<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 04.10.17
 * Time: 21:38
 */

namespace site\services\warranty;


use site\entities\Warranty\Warranty;
use site\forms\warranty\WarrantyForm;
use site\repositories\WarrantyRepository;

class WarrantyService
{
    private $repository;


    public function __construct(
        WarrantyRepository $repository
    )
    {
        $this->repository = $repository;
    }

    public function create(WarrantyForm $form): Warranty
    {
        $warranty = Warranty::create(
            $form->customer_id,
            $form->device_name,
            $form->part_number,
            $form->serial_number,
            $form->invoice_number,
            $form->invoice_date,
            $form->act_number,
            $form->act_date
        );
        $this->repository->save($warranty);
        return $warranty;
    }

    public function edit($id, WarrantyForm $form): void
    {
        $warranty = $this->repository->findById($id);
        $warranty->edit(
            $form->customer_id,
            $form->device_name,
            $form->part_number,
            $form->serial_number,
            $form->invoice_number,
            $form->invoice_date,
            $form->act_number,
            $form->act_date
        );
        $this->repository->save($warranty);
    }


    public function remove($id): void
    {
        $warranty = $this->repository->findById($id);
        $this->repository->remove($warranty);
    }
}
