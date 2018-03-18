<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 04.10.17
 * Time: 21:38
 */

namespace site\services\warranty;

use DateTime;
use site\entities\Warranty\Warranty;
use site\forms\warranty\WarrantyCreateForm;
use site\forms\warranty\WarrantyEditForm;
use site\forms\warranty\WarrantySettingsEditForm;
use site\repositories\WarrantyRepository;
use site\repositories\WarrantySettingsRepository;
use Yii;
use yii\base\Model;

class WarrantySettingsService
{
    private $repository;


    public function __construct(
        WarrantySettingsRepository $repository
    )
    {
        $this->repository = $repository;
    }

    public function edit($id, WarrantySettingsEditForm $form): void
    {
        $warrantySetting = $this->repository->findById($id);
        $warrantySetting->edit(
            $form->value,
            $form->description
        );
        $this->repository->save($warrantySetting);
    }
}
