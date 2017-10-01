<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 30.09.17
 * Time: 15:44
 */

namespace console\controllers;




use common\rbac\userGroupRule;
use site\access\Rbac;
use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $authManager = Yii::$app->authManager;
        $authManager->removeAll();

        $guest  = $authManager->createRole(Rbac::ROLE_GUEST);
        $guest->description = 'Гость';
        $dealer  = $authManager->createRole(Rbac::ROLE_DEALER);
        $dealer->description = 'Диллер';
        $admin  = $authManager->createRole(Rbac::ROLE_ADMIN);
        $admin->description = 'Администратор';

        // Create simple, based on action{$NAME} permissions
        $login  = $authManager->createPermission('login');
        $logout = $authManager->createPermission('logout');
        $error  = $authManager->createPermission('error');
        $signUp = $authManager->createPermission('sign-up');
        $index  = $authManager->createPermission('index');
        $view   = $authManager->createPermission('view');
        $update = $authManager->createPermission('update');
        $delete = $authManager->createPermission('delete');
//админка
        $indexAdmin = $authManager->createPermission('indexAdmin');
        $gii = $authManager->createPermission('gii');

        // Add permissions in Yii::$app->authManager
        $authManager->add($login);
        $authManager->add($logout);
        $authManager->add($error);
        $authManager->add($signUp);
        $authManager->add($index);
        $authManager->add($view);
        $authManager->add($update);
        $authManager->add($delete);
        $authManager->add($indexAdmin);
        $authManager->add($gii);

        // Add rule, based on UserExt->group === $user->group
        $userGroupRule = new UserGroupRule();
        $authManager->add($userGroupRule);

        // Add rule "UserGroupRule" in roles
        $guest->ruleName  = $userGroupRule->name;
        $dealer->ruleName  = $userGroupRule->name;
        $admin->ruleName  = $userGroupRule->name;

        // Add roles in Yii::$app->authManager
        $authManager->add($guest);
        $authManager->add($dealer);
        $authManager->add($admin);

        // Add permission-per-role in Yii::$app->authManager
        // Guest
        $authManager->addChild($guest, $login);
        $authManager->addChild($guest, $logout);
        $authManager->addChild($guest, $error);
        $authManager->addChild($guest, $signUp);
        $authManager->addChild($guest, $index);
        $authManager->addChild($guest, $view);

        // dealer
        $authManager->addChild($dealer, $update);
        $authManager->addChild($dealer, $guest);

        // Admin
        $authManager->addChild($admin, $delete);
        $authManager->addChild($admin, $dealer);
        $authManager->addChild($admin, $indexAdmin);
        $authManager->addChild($admin, $gii);

    }

}