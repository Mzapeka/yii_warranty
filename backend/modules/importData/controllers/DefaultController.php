<?php

namespace app\modules\importData\controllers;

use app\modules\importData\forms\OldDbCredentialForm;
use console\models\MigrateOldDb;
use yii\web\Controller;

/**
 * Default controller for the `importData` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $model = new OldDbCredentialForm();
        $model->loadFromParams();
        return $this->render('index',[
            'model' => $model,
        ]);
    }

    public function actionDbImport()
    {
//todo: сделать нормально исключения
        $data = new MigrateOldDb($host,$dbName,$userName,$pass);
        //$data->getTableData('users')
        try{
            //$data->getBtsNiknames();
            //$data->getUsersNiknames();
            //$data->importBts();
            $data->importCustomer();
        }catch (\RuntimeException $e){
            echo $e->getMessage();
        }
        echo 'Process was finished success';
    }

    public function actionTest()
    {
        return $this->renderContent('HELLO');
    }


}
