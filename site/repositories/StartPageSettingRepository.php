<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 04.10.17
 * Time: 23:54
 */

namespace site\repositories;




use site\entities\StartPageSetting\StartPageSetting;

class StartPageSettingRepository
{

    public function findById($id): ?StartPageSetting
    {
        return $this->getBy(['id' => $id]);
    }

    public function save(StartPageSetting $startPageSetting): void
    {
        if (!$startPageSetting->save()) {
            throw new \RuntimeException('Saving error.');
        }
        return;
    }

    public function remove(StartPageSetting $startPageSetting): void
    {
        if (!$startPageSetting->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }

    private function getBy(array $condition): ?StartPageSetting
    {
        if (!$startPageSetting = StartPageSetting::find()->andWhere($condition)->limit(1)->one()) {
            throw new NotFoundException('Customer not found.');
        }
        return $startPageSetting;
    }
}