<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 04.10.17
 * Time: 23:54
 */

namespace site\repositories;


use site\entities\Customer\Customer;

class CustomerRepository
{

    public function findById($id): ?Customer
    {
        return $this->getBy(['id' => $id]);
    }


    public function countById($id): int
    {
        return Customer::find()->andWhere(['id' => $id])->count();
    }

    public function getAllByRange(int $offset, int $limit): array
    {
        return Customer::find()->alias('c')->orderBy(['id' => SORT_ASC])->limit($limit)->offset($offset)->all();
    }


    //todo: Дописать остальные методы
    //todo: Сделать сервис гарантии



    public function save(Customer $customer): void
    {
        if (!$customer->save()) {
            throw new \RuntimeException('Saving error.');
        }
        return;
    }

    public function remove(Customer $customer): void
    {
        if (!$customer->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }

    private function getBy(array $condition): ?Customer
    {
        if (!$customer = Customer::find()->andWhere($condition)->limit(1)->one()) {
            throw new NotFoundException('Customer not found.');
        }
        return $customer;
    }
}