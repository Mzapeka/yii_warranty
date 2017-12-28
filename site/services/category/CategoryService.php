<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 28.12.17
 * Time: 22:25
 */

namespace site\services\category;


use backend\modules\catalogManager\models\B2bPortalCategory;
use site\entities\Catalog\Category;


class CategoryService
{
    /**
     * Array of modules\catalogManager\models\B2bPortalCategory
     * @param array $categoriesArray
     */
    public function importCategories(array $categoriesArray): CategoryImportResult
    {
        if(!$categoriesArray || !array_walk($categoriesArray, function($val){return $val instanceof B2bPortalCategory;})){
            throw new \RuntimeException('Ошибка импорта категорий');
        }

        $root = Category::find()->roots()->one();

        if(!$root){
            $root = new Category([
                'name'=>'Все категории',
                'local_source' => 0,
                'description' => '',
            ]);
            $root->makeRoot();
        }

        $parent_category = array(
            1=>$root
        );

        $lastLevel = 1;
        $lastNode = null;

        $importResult = new CategoryImportResult();
        $importResult->setTotalCategoriesOnPortal(count($categoriesArray));
        /**
        * @var B2bPortalCategory $b2bPortalCategory
         */
        foreach ($categoriesArray as $b2bPortalCategory){
            if($b2bPortalCategory->level > $lastLevel){
                $parent_category[$b2bPortalCategory->level] = $lastNode;
            }
            $node = Category::find()->andWhere(['old_id'=>$b2bPortalCategory->id])->one();

            if(!$node){
                $node = new Category([
                    'name' => $b2bPortalCategory->name,
                    'old_id' => $b2bPortalCategory->id,
                    'local_source' => 0,
                    'description' => '',
                ]);
                $node->appendTo($parent_category[$b2bPortalCategory->level]);
                $importResult->incrementTotalCategoriesImported();
            }
            $lastNode = $node;
            $lastLevel = $b2bPortalCategory->level;
        }
        return $importResult;
    }
}