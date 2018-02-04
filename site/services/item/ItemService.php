<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 05.10.17
 * Time: 0:04
 */

namespace site\services\item;


use common\modules\catalogManager\B2bPortalDocument;
use site\entities\Catalog\Item;
use site\forms\item\ItemCreateForm;
use site\forms\item\ItemEditForm;
use site\helpers\CategoryHelper;
use site\repositories\ItemRepository;
use Yii;
use yii\web\UploadedFile;

class ItemService
{
    private $repository;


    public function __construct(
        ItemRepository $repository
    )
    {
        $this->repository = $repository;
    }

    /**
     * @var UploadedFile $document
     * @return Item
     */
    public function create(ItemCreateForm $form): Item
    {
        $document = UploadedFile::getInstance($form, 'document');
        $fileName = $document->baseName.'.'.$document->extension;

        $customer = Item::create(
            $form->name,
            $form->category_id,
            $document->extension,
            Yii::$app->formatter->asShortSize($document->size),
            $form->description,
            $form->disabled,
            null,
            $fileName
        );
        $this->repository->save($customer);

        $document->saveAs(Yii::getAlias(Yii::$app->params['fileStorage']).'/'.$fileName);

        return $customer;
    }

    public function edit($id, ItemEditForm $form): void
    {
        $item = $this->repository->findById($id);
        $item->edit(
            $form->name,
            $form->category_id,
            $form->file_type,
            $form->file_size,
            $form->description,
            $form->disabled,
            $form->old_id
        );
        $this->repository->save($item);
    }

    public function remove($id): void
    {
        $item = $this->repository->findById($id);
        $this->repository->remove($item);
    }

    public function importDocuments(B2bPortalDocument $documents)
    {
        /**
         * @var B2bPortalDocument $document
         */
        $result['all'] = $documents->count();
        $result['notImported'] = 0;
        $result['imported'] = 0;

        foreach ($documents as $document){
            $categoryId = CategoryHelper::getIdByOldId($document->category_id);
            if(!$categoryId){
                ++$result['notImported'];
                continue;
            }
            $document = Item::create(
                $document->name,
                $categoryId,
                $document->file_type,
                $document->file_size,
                '',
                0,
                $document->id
            );
            try {
                $this->repository->saveFromPortal($document);
            }catch (\RuntimeException $e){
                ++$result['notImported'];
                Yii::$app->errorHandler->logException($e);
            }
        }
        $result['imported'] = $result['all'] - $result['notImported'];
        return $result;
    }
}