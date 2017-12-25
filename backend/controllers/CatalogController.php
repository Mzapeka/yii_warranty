<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 25.12.17
 * Time: 14:41
 */

namespace backend\controllers;


use yii\web\Controller;

class CatalogController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}