<?php

namespace site\services\user;

use site\access\Rbac;
use site\entities\User\User;
use site\forms\User\UserCreateForm;
use site\forms\User\UserEditForm;
use site\repositories\UserRepository;
use yii\mail\MailerInterface;


class UserManageService
{
    private $repository;
    private $mailer;

    public function __construct(
        UserRepository $repository,
        MailerInterface $mailer
    )
    {
        $this->repository = $repository;
        $this->mailer = $mailer;
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

    public function activate($id)
    {
        $user = $this->repository->get($id);
        $user->group = Rbac::ROLE_DEALER;
        $this->repository->save($user);

        $sent = $this->mailer
            ->compose(
                ['html'=>'auth/signup/activate-notification-html'],
                ['user'=>$user]
            )
            ->setTo($user->email)
            ->setSubject('Активация аккаунта компании '. $user->company)
            ->send();
        if (!$sent){
            throw new \RuntimeException('Email sending error');
        }
    }
}