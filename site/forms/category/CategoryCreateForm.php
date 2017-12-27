<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 05.10.17
 * Time: 0:16
 */

namespace site\forms\category;


use yii\base\Model;
use yii\helpers\ArrayHelper;

class CategoryCreateForm extends Model
{


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['root', 'lft', 'rgt', 'lvl', 'icon_type', 'active', 'selected', 'disabled', 'readonly', 'visible', 'collapsed', 'movable_u', 'movable_d', 'movable_l', 'movable_r', 'removable', 'removable_all', 'old_id', 'local_source'], 'integer'],
            [['lft', 'rgt', 'lvl', 'name', 'description'], 'required'],
            [['name'], 'string', 'max' => 60],
            [['icon', 'description'], 'string', 'max' => 255],
        ];
    }

}