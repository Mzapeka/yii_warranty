<?php

namespace site\services\user;

use site\entities\User\User;
use site\forms\User\UserCreateForm;
use site\forms\User\UserEditForm;
use site\repositories\UserRepository;


class UserManageService
{
    private $repository;


    public function __construct(
        UserRepository $repository
    )
    {
        $this->repository = $repository;
    }

    public function create(UserCreateForm $form): User
    {
        $user = User::create(
            $form->username,
            $form->email,
            $form->phone,
            $form->email,
            $form->company,
            $form->adress,
            $form->group
        );
            $this->repository->save($user);
        return $user;
    }

    public function edit($id, UserEditForm $form): void
    {
        $user = $this->repository->get($id);
        $user->edit(
            $form->username,
            $form->email,
            $form->phone,
            $form->company,
            $form->adress,
            $form->group
        );
            $this->repository->save($user);
    }


    public function remove($id): void
    {
        $user = $this->repository->get($id);
        $this->repository->remove($user);
    }

    public function isEmailExist(string $email){
        return $this->repository::isEmailExist($email);
    }
}