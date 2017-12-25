<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 25.12.17
 * Time: 14:25
 */

namespace app\modules\catalogManager\models;


use kartik\tree\models\Tree;

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

}