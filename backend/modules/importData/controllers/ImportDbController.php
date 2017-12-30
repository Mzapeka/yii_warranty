<?php

namespace app\modules\importData\controllers;

use app\modules\importData\forms\OldDbCredentialForm;
use app\modules\importData\ImportDataBundle;
use app\modules\importData\models\MigrateOldDb;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

/**
 * Default controller for the `importData` module
 */
class ImportDbController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        ImportDataBundle::register($this->view);
        $model = new OldDbCredentialForm();
        $model->loadFromParams();
        return $this->render('index',[
            'model' => $model,
            'notification' => '',
        ]);
    }

    public function actionDbConnectionCheck()
    {
        $form = new OldDbCredentialForm();
        $migrateModel = Yii::$container->get(MigrateOldDb::class);

        $notification = 'Ошибка валидации данных';
        $connectionStatus = false;

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $notification = 'Подключение к базе данных прошло успешно';
            $connectionStatus = true;
            try{
                $migrateModel->connect($form);
            } catch (\Exception $e) {
                Yii::$app->errorHandler->logException($e);
                $notification = $e->getMessage();
                $connectionStatus = false;
            }
        }

        return $this->renderPartial('notification', [
            'notification' => $notification,
            'connectionStatus' => $connectionStatus,
        ]);
    }

    public function actionDbImport()
    {
        ImportDataBundle::register($this->view);

        $form = new OldDbCredentialForm();
        $migrateModel = Yii::$container->get(MigrateOldDb::class);

        $result = [];
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {

            try{
                $migrateModel->connect($form);
                $result = $migrateModel->importDataBase();
            } catch (\Exception $e) {
                Yii::$app->errorHandler->logException($e);
                $result['error'] = $e->getMessage();
            }
        }

        $notification = null;
        $connectionStatus = false;
        if(ArrayHelper::keyExists('error', $result)){
            $notification = $result['error'];
        }
        else {
            $notification = $this->renderPartial('successNotification', [
               'notification' => $result,
            ]);
            $connectionStatus = true;
        }

        return $this->render('index', [
            'model' => $form,
            'notification' => $this->renderPartial('notification', [
                'notification' => $notification,
                'connectionStatus' => $connectionStatus,
            ])
        ]);
    }

}
