<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 05.10.17
 * Time: 0:04
 */

namespace site\services\customer;


use site\entities\Customer\Customer;
use site\repositories\CustomerRepository;

class CustomerService
{
    private $repository;


    public function __construct(
        CustomerRepository $repository
    )
    {
        $this->repository = $repository;
    }

    public function create(CustomerForm $form): Customer
    {
        $customer = Customer::create(
            $form->dealer_id,
            $form->email,
            $form->customer_name,
            $form->adress,
            $form->phone
        );
        $this->repository->save($customer);
        return $customer;
    }

    public function edit($id, CustomerForm $form): void
    {
        $customer = $this->repository->findById($id);
        $customer->edit(
            $form->dealer_id,
            $form->email,
            $form->customer_name,
            $form->adress,
            $form->phone
        );
        $this->repository->save($customer);
    }


    public function remove($id): void
    {
        $customer = $this->repository->findById($id);
        $this->repository->remove($customer);
    }
}