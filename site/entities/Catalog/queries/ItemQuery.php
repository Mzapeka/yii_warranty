<?php

namespace site\entities\Catalog\queries;

use site\entities\Catalog\Item;
use yii\db\ActiveQuery;

class ItemQuery extends ActiveQuery
{
    /**
     * @param null $alias
     * @return $this
     */
    public function active($alias = null)
    {
/*        return $this->andWhere([
            ($alias ? $alias . '.' : '') . 'status' => Item::STATUS_ACTIVE,
        ]);*/
        return $this;
    }

}