<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 30.09.17
 * Time: 15:59
 */

namespace common\rbac;


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

            if ($item->name === 'admin') {
                return $group == 'admin';
            } elseif ($item->name === 'dealer') {
                return $group == 'admin' || $group == 'dealer';
            } elseif ($item->name === 'guest') {
                return $group == 'admin' || $group == 'dealer' || $group == 'guest';
            }

        return false;
    }

}