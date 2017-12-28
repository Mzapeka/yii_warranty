<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 02.10.17
 * Time: 23:49
 */

namespace site\repositories;


use site\entities\Warranty\Warranty;

class WarrantyRepository
{

    public function findActiveById($id): ?Warranty
    {
        return $this->getBy(['id' => $id, 'status' => Warranty::STATUS_ACTIVE]);
    }


    public function findById($id): ?Warranty
    {
        return $this->getBy(['id' => $id]);
    }


    public function count(): int
    {
        return Warranty::find()->andWhere(['status' => Warranty::STATUS_ACTIVE])->count();
    }

    public function getAllByRange(int $offset, int $limit): array
    {
        return Warranty::find()->alias('w')->andWhere(['w.status' => Warranty::STATUS_ACTIVE])->orderBy(['id' => SORT_ASC])->limit($limit)->offset($offset)->all();
    }




    public function save(Warranty $warranty): void
    {
        if (!$warranty->save()) {
            throw new \RuntimeException('Saving error.');
        }
        return;
    }

    public function remove(Warranty $warranty): void
    {
        if (!$warranty->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }

    private function getBy(array $condition): ?Warranty
    {
        if (!$warranty = Warranty::find()->andWhere($condition)->limit(1)->one()) {
            throw new NotFoundException('Warranty not found.');
        }
        return $warranty;
    }

    public function findOneBySerialNumber(string $serialNumber): ?Warranty
    {
        if (!$warranty = Warranty::findOne(['serial_number' => $serialNumber])){
            throw new NotFoundException('Гарантия не найдена');
        }
        return $warranty;
    }
}