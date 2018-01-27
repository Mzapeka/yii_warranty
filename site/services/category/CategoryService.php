<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 28.12.17
 * Time: 22:25
 */

namespace site\services\category;



use common\modules\catalogManager\B2bPortalCategory;
use site\entities\Catalog\Category;


class CategoryService
{
    /**
     * Array of modules\catalogManager\models\B2bPortalCategory
     * @param B2bPortalCategory $categories
     */
    public function importCategories(B2bPortalCategory $categories): CategoryImportResult
    {
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
        $importResult->setTotalCategoriesOnPortal(count($categories));
        /**
        * @var B2bPortalCategory $b2bPortalCategory
         */
        foreach ($categories as $b2bPortalCategory){
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