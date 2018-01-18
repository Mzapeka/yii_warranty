<?php

namespace site\entities\Catalog;

use kartik\tree\models\Tree;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "catalog_categories".
 *
 * @property int $id
 * @property int $root
 * @property int $lft
 * @property int $rgt
 * @property int $lvl
 * @property string $name
 * @property string $icon
 * @property int $icon_type
 * @property int $active
 * @property int $selected
 * @property int $disabled
 * @property int $readonly
 * @property int $visible
 * @property int $collapsed
 * @property int $movable_u
 * @property int $movable_d
 * @property int $movable_l
 * @property int $movable_r
 * @property int $removable
 * @property int $removable_all
 * @property int $old_id
 * @property int $local_source
 * @property string $description
 *
 */
class Category extends Tree
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_categories';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $attributeLabel = parent::attributeLabels();
        $result = ArrayHelper::merge($attributeLabel, [
            'old_id' => 'Old ID',
            'local_source' => 'Local Source',
            'description' => 'Description',
        ]);
        return $result;
    }

    public function rules()
    {
        $rules = parent::rules();
        $rules[] = ['description', 'safe'];
        $rules[] = ['local_source', 'integer'];
        $rules[] = ['old_id', 'safe'];
        return $rules;
    }

}
