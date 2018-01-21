<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 18.01.18
 * Time: 22:30
 */

namespace site\repositories;


use site\entities\Catalog\Category;


class CategoryRepository
{
    public function getRoot(): Category
    {
        return Category::find()->roots()->one();
    }

    /**
     * @return Category[]
     */
    public function getAll(): array
    {
        return Category::find()->andWhere(['>', 'lvl', 0])->orderBy('lft')->all();
    }

    public function find($id): ?Category
    {
        return Category::find()->andWhere(['id' => $id])->andWhere(['>', 'lvl', 0])->one();
    }


}