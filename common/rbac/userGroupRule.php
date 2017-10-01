<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 30.09.17
 * Time: 15:59
 */

namespace common\rbac;


use site\access\Rbac;
use yii\rbac\Item;
use yii\rbac\Rule;

class userGroupRule extends Rule
{
    public $name = 'userGroup';
    /**
     * Executes the rule.
     *
     * @param string|int $user the user ID. This should be either an integer or a string representing
     * the unique identifier of a user. See [[\yii\web\User::id]].
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to [[CheckAccessInterface::checkAccess()]].
     * @return bool a value indicating whether the rule permits the auth item it is associated with.
     */
    public function execute($user, $item, $params)
    {

         $group = (!\Yii::$app->user->isGuest) ? \Yii::$app->user->identity->group : 'guest';

            if ($item->name === Rbac::ROLE_ADMIN) {
                return $group == Rbac::ROLE_ADMIN;
            } elseif ($item->name === Rbac::ROLE_DEALER) {
                return $group == Rbac::ROLE_ADMIN || $group == Rbac::ROLE_DEALER;
            } elseif ($item->name === Rbac::ROLE_GUEST) {
                return $group == Rbac::ROLE_ADMIN || $group == Rbac::ROLE_DEALER || $group == Rbac::ROLE_GUEST;
            }

        return false;
    }

}