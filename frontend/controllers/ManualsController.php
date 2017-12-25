<?php

namespace frontend\controllers;

use yii\web\Controller;

class ManualsController extends Controller
{

    public $layout = '@app/views/layouts/manager/main.php';

    public function actionIndex()
    {
        return $this->render('index');
    }

}
