<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 04.10.17
 * Time: 23:54
 */

namespace site\repositories;


use site\entities\Catalog\Category;
use site\entities\Catalog\Item;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;


class ItemRepository
{

    public function findById($id): ?Item
    {
        return $this->getBy(['id' => $id]);
    }


    public function getAllByRange(int $offset, int $limit): array
    {
        return Item::find()->alias('c')->orderBy(['id' => SORT_ASC])->limit($limit)->offset($offset)->all();
    }


    public function save(Item $item): void
    {
        if (!$item->save()) {
            throw new \RuntimeException('Saving error.');
        }
        return;
    }

    public function saveFromPortal(Item $item): void
    {
        try{
            $this->getBy(['old_id'=>$item->old_id]);
        }catch (NotFoundException $e){
            $this->save($item);
            return;
        }
            throw new \RuntimeException('This document already added.');
    }

    public function remove(Item $item): void
    {
        if (!$item->delete()) {
            throw new \RuntimeException('Removing error.');
        }

        //todo: проверка на наличие локального файла документа
    }

    private function getBy(array $condition): ?Item
    {
        if (!$item = Item::find()->andWhere($condition)->limit(1)->one()) {
            throw new NotFoundException('Item not found.');
        }
        return $item;
    }

    public function getAll(): DataProviderInterface
    {
        /**
         * @var CategoryRepository $catRepository
         */
        $catRepository = \Yii::$container->get(CategoryRepository::class);
        return $this->getAllByCategory($catRepository->getRoot());
    }

    private function getProvider(ActiveQuery $query): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
                'attributes' => [
                    'id' => [
                        'asc' => ['i.id' => SORT_ASC],
                        'desc' => ['i.id' => SORT_DESC],
                    ],
                    'name' => [
                        'asc' => ['i.name' => SORT_ASC],
                        'desc' => ['i.name' => SORT_DESC],
                    ],
                    'price' => [
                        'asc' => ['i.file_type' => SORT_ASC],
                        'desc' => ['i.file_type' => SORT_DESC],
                    ],
                    'rating' => [
                        'asc' => ['i.file_size' => SORT_ASC],
                        'desc' => ['i.file_size' => SORT_DESC],
                    ],
                ],
            ],
            'pagination' => [
                'pageSizeLimit' => [10, 50],
            ]
        ]);
    }

    public function getAllByCategory(Category $category): ?DataProviderInterface
    {
        $ids = null;
        if($category->isActive()){
            $ids = ArrayHelper::merge([$category->id], $category->children()->andWhere(['active'=>1])->select('id')->column());
        }
        $query = Item::find()->alias('i')->active('i');

        $query->andWhere(['i.category_id' => $ids]);
        $query->groupBy('i.id');
        return $this->getProvider($query);
    }

}