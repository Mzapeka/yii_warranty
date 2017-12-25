<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 25.12.17
 * Time: 14:25
 */

namespace app\modules\catalogManager\models;


use kartik\tree\models\Tree;
use site\access\Rbac;
use Yii;

class TreeBuilder extends Tree
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_categories';
    }

    public function rules()
    {
        $rules = parent::rules();
        $rules[] = ['description', 'safe'];
        return $rules;
    }

    /**
     * Override isDisabled method if you need as shown in the
     * example below. You can override similarly other methods
     * like isActive, isMovable etc.
     */
/*    public function isDisabled()
    {
        if (Yii::$app->getUser()->group !== Rbac::ROLE_ADMIN) {
            return true;
        }
        return parent::isDisabled();
    }*/
}