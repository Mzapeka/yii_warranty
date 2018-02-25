<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 05.10.17
 * Time: 0:04
 */

namespace site\services\startPageSetting;


use site\entities\StartPageSetting\StartPageSetting;
use site\forms\startPageSetting\StartPageSettingCreateForm;
use site\forms\startPageSetting\StartPageSettingEditForm;
use site\repositories\StartPageSettingRepository;

class StartPageSettingService
{
    private $repository;


    public function __construct(
        StartPageSettingRepository $repository
    )
    {
        $this->repository = $repository;
    }

    public function create(StartPageSettingCreateForm $form): StartPageSetting
    {
        $startPageSetting = StartPageSetting::create(
            $form->name,
            $form->url,
            $form->icon
        );
        $this->repository->save($startPageSetting);
        return $startPageSetting;
    }

    public function edit($id, StartPageSettingEditForm $form): void
    {
        $startPageSetting = $this->repository->findById($id);
        $startPageSetting->edit(
            $form->name,
            $form->url,
            $form->icon
        );
        $this->repository->save($startPageSetting);
    }


    public function remove($id): void
    {
        $startPageSetting = $this->repository->findById($id);
        $this->repository->remove($startPageSetting);
    }
}