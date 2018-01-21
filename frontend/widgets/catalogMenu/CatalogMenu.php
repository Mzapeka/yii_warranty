<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 21.01.18
 * Time: 12:40
 */

namespace app\widgets\catalogMenu;


use kartik\sidenav\SideNav;
use site\repositories\CategoryRepository;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @property CategoryRepository $categoryRepository
*/

class CatalogMenu extends SideNav
{
    private $categoryRepository;

    public function init()
    {
        $this->categoryRepository = new CategoryRepository();
        $this->items = $this->getMenuData();
        parent::init();
    }

    /**
     * @param int|null $id
     * @return array
     */
    private function getMenuData(int $id = null):array
    {
        $rootCategory = $id ? $this->categoryRepository->find($id) : $this->categoryRepository->getRoot();
        $categories = $rootCategory->children(1)->all();

        if(!$categories){
            return [];
        }

        $categoriesInMenuFormat = [];
        foreach ($categories as $category){
            $array = [
                'label' => $category->name,
                'icon' => $category->icon,
                'url' => Html::encode(Url::to(['/manuals/category', 'id' => $category->id])),
                'active' => false,
            ];
            if($items = $this->getMenuData($category->id)){
                $array['items'] = $items;
            }
            $categoriesInMenuFormat[] = $array;
        }
        return $categoriesInMenuFormat;
    }

}