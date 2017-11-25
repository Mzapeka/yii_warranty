<?php

namespace app\modules\importData\controllers;

use app\modules\importData\forms\OldDbCredentialForm;
use app\modules\importData\ImportDataBundle;
use app\modules\importData\models\MigrateOldDb;
use Yii;
use yii\web\Controller;

/**
 * Default controller for the `importData` module
 */
class DefaultController extends Controller
{
    //private $migrateModel;
/*    public function __construct($id, $module, MigrateOldDb $migrateModel, array $config = [])
    {
        $this->migrateModel = $migrateModel;
        parent::__construct($id, $module, $config);
    }*/

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
//todo: сделать нормально исключения

        $form = new OldDbCredentialForm();
        $migrateModel = Yii::$container->get(MigrateOldDb::class);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try{
                $migrateModel->connect($form);
                //return $this->redirect(['view', 'id' => $user->id]);
            } catch (\Exception $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        //return $this->renderContent('Succsess');
                return $this->render('index', [
            'model' => $form,
        ]);



        //$data->getTableData('users')
/*        try{
            //$data->getBtsNiknames();
            //$data->getUsersNiknames();
            //$data->importBts();
            $data->importCustomer();
        }catch (\RuntimeException $e){
            echo $e->getMessage();
        }
        echo 'Process was finished success';*/
    }

    public function actionTest()
    {
        return $this->renderContent('HELLO');
    }


}
