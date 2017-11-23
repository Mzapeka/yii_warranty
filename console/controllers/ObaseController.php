<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 19.11.17
 * Time: 18:50
 */

namespace console\controllers;


use console\models\MigrateOldDb;
use yii\console\Controller;

class ObaseController extends Controller
{
    public function actionInit()
    {
        $host = 'mzapeka.mysql.tools';
        $dbName = 'mzapeka_boschwar';
        $userName = 'mzapeka_boschwar';
        $pass = '6qsqcjfy';

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
        echo \Yii::$app->params['host'];
    }
}