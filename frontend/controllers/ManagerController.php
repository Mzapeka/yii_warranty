<?php

namespace frontend\controllers;

use yii\web\Controller;

class ManagerController extends Controller
{
    public $layout = '@app/views/layouts/manager/main.php';

    public function actionIndex()
    {
        return $this->render('index');
    }

}
