<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 05.10.17
 * Time: 0:04
 */

namespace site\services\item;


use site\entities\Catalog\Item;
use site\forms\item\ItemCreateForm;
use site\forms\item\ItemEditForm;
use site\repositories\ItemRepository;

class ItemService
{
    private $repository;


    public function __construct(
        ItemRepository $repository
    )
    {
        $this->repository = $repository;
    }

    public function create(ItemCreateForm $form): Item
    {
        $customer = Item::create(
            $form->name,
            $form->category_id,
            $form->file_type,
            $form->file_size,
            $form->description,
            $form->disabled,
            $form->old_id
        );
        $this->repository->save($customer);
        return $customer;
    }

    public function edit($id, ItemEditForm $form): void
    {
        $item = $this->repository->findById($id);
        $item->edit(
            $form->name,
            $form->category_id,
            $form->file_type,
            $form->file_size,
            $form->description,
            $form->disabled,
            $form->old_id
        );
        $this->repository->save($item);
    }

    public function remove($id): void
    {
        $item = $this->repository->findById($id);
        $this->repository->remove($item);
    }
}