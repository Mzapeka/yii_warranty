<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 04.10.17
 * Time: 23:54
 */

namespace site\repositories;


use site\entities\Catalog\Item;


class ItemRepository
{

    public function findById($id): ?Item
    {
        return $this->getBy(['id' => $id]);
    }


    public function getAllByRange(int $offset, int $limit): array
    {
        return Item::find()->alias('c')->orderBy(['id' => SORT_ASC])->limit($limit)->offset($offset)->all();
    }


    public function save(Item $item): void
    {
        if (!$item->save()) {
            throw new \RuntimeException('Saving error.');
        }
        return;
    }

    public function saveFromPortal(Item $item): void
    {
        try{
            $this->getBy(['old_id'=>$item->old_id]);
        }catch (NotFoundException $e){
            $this->save($item);
            return;
        }
            throw new \RuntimeException('This document already added.');
    }

    public function remove(Item $item): void
    {
        if (!$item->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }

    private function getBy(array $condition): ?Item
    {
        if (!$item = Item::find()->andWhere($condition)->limit(1)->one()) {
            throw new NotFoundException('Item not found.');
        }
        return $item;
    }
}