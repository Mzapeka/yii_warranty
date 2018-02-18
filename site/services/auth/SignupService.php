<?php

namespace site\services\auth;

/*use shop\access\Rbac;*/
/*use shop\dispatchers\EventDispatcher;*/
use site\entities\User\User;
use site\forms\auth\SignupForm;
use site\repositories\UserRepository;
use yii\mail\MailerInterface;

/*use shop\services\RoleManager;
use shop\services\TransactionManager;*/

class SignupService
{
    private $users;
    private $mailer;
/*    private $roles;
    private $transaction;*/

    public function __construct(
        UserRepository $users,
        MailerInterface $mailer
/*        RoleManager $roles,
        TransactionManager $transaction*/
    )
    {
        $this->users = $users;
        $this->mailer = $mailer;
/*        $this->roles = $roles;
        $this->transaction = $transaction;*/
    }

    public function signup(SignupForm $form): void
    {
        $user = User::requestSignup(
            $form->username,
            $form->email,
            $form->password,
            $form->company,
            $form->adress,
            $form->phone
        );
        $this->users->save($user);

        $sent = $this->mailer
            ->compose(
                ['html'=>'auth/signup/confirm-html', 'text'=>'auth/signup/confirm-text'],
                ['user'=>$user]
            )
            ->setTo($user->email)
            ->setSubject('Email confirm for '. \Yii::$app->name)
            ->send();
        if (!$sent){
            throw new \RuntimeException('Email sending error');
        }

/*        $this->transaction->wrap(function () use ($user) {
            $this->users->save($user);
            $this->roles->assign($user->id, Rbac::ROLE_USER);
        });*/
    }

    public function confirm($token): void
    {
        if (empty($token)) {
            throw new \DomainException('Empty confirm token.');
        }
        $user = $this->users->getByEmailConfirmToken($token);
        $user->confirmSignup();
        $this->users->save($user);

        //email администратору
        $sent = $this->mailer
            ->compose(
                ['html'=>'auth/signup/confirm-admin-html'],
                ['user'=>$user]
            )
            ->setTo(\Yii::$app->params['adminEmail'])
            ->setSubject('Активация аккаунта компании '. $user->company)
            ->send();
        if (!$sent){
            throw new \RuntimeException('Email sending error');
        }
    }
}