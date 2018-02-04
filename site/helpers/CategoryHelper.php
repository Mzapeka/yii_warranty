<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 03.01.18
 * Time: 23:01
 */

namespace site\helpers;


use site\entities\Catalog\Category;

class CategoryHelper
{
    public static function getIdByOldId($oldId){
        return Category::find()->where(['old_id'=>$oldId])->one()?Category::find()->where(['old_id'=>$oldId])->one()->id:null;
    }

    public static function getCategoryNameById($id){
        return Category::find()->where(['id' => $id])->one() ? Category::find()->where(['id' => $id])->one()->name:null;
    }

}