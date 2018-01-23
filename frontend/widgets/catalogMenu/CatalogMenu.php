<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 21.01.18
 * Time: 12:40
 */

namespace app\widgets\catalogMenu;


use kartik\sidenav\SideNav;
use site\entities\Catalog\Category;
use site\repositories\CategoryRepository;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @property CategoryRepository $categoryRepository
 * @property Category $activeCategory
*/

class CatalogMenu extends SideNav
{
    private $categoryRepository;
    public $activeCategory = false;

    public function init()
    {
        $this->categoryRepository = new CategoryRepository();
        $this->items = $this->getMenuData();
        $this->setActiveParents($this->items);
        parent::init();
    }

    /**
     * @param int|null $id
     * @return array
     */
    private function getMenuData(int $id = null):array
    {
        $rootCategory = $id ? $this->categoryRepository->find($id) : $this->categoryRepository->getRoot();
        $categories = $rootCategory ? $rootCategory->children(1)->andWhere(['active'=>true])->all() : null;

        if(!$categories){
            return [];
        }

        $categoriesInMenuFormat = [];
        foreach ($categories as $category){
            $array = [
                'label' => $category->name,
                'icon' => $category->icon,
                'url' => Html::encode(Url::to(['/manuals/category', 'id' => $category->id])),
                'active' => (bool)$this->activeCategory && ($this->activeCategory->id == $category->id),
                'visible' => true,
            ];
            if($items = $this->getMenuData($category->id)){
                $array['items'] = $items;
            }
            $categoriesInMenuFormat[] = $array;
        }
        return $categoriesInMenuFormat;
    }

    private function setActiveParents(array &$menuArray){
        if(!$menuArray){
            return false;
        }

        foreach ($menuArray as $key => &$item){
            if($item['active'] === true){
                return true;
            }
            if(key_exists('items', $item) && is_array($item['items'])){
                if($this->setActiveParents($item['items'])){
                    $menuArray[$key]['active'] = true;
                    return true;
                }
            }
        }
        return false;
    }

}