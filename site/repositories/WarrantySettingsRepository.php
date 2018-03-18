<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 02.10.17
 * Time: 23:49
 */

namespace site\repositories;


use site\entities\Warranty\WarrantySettings;

class WarrantySettingsRepository
{


    public function findById($id): ?WarrantySettings
    {
        return $this->getBy(['id' => $id]);
    }

    public function findByKey($key): ?WarrantySettings
    {
        return $this->getBy(['key' => $key]);
    }

    public function save(WarrantySettings $warrantySettings): void
    {
        if (!$warrantySettings->save()) {
            throw new \RuntimeException('Saving error.');
        }
        return;
    }

    private function getBy(array $condition): ?WarrantySettings
    {
        if (!$warranty = WarrantySettings::find()->andWhere($condition)->limit(1)->one()) {
            throw new NotFoundException('Warranty Setting not found.');
        }
        return $warranty;
    }

}