<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 25.12.17
 * Time: 14:41
 */

namespace backend\controllers;


use backend\modules\catalogManager\models\ImportCatalog;
use site\entities\Catalog\Category;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;

class CategoryController extends Controller
{
    public function actionIndex()
    {
        $category = Category::find()->addOrderBy('root, lft');
        return $this->render('index',[
            'query' => $category,
        ]);
    }

    public function actionCatalogImport(){
        $importModel = new ImportCatalog(
            Yii::$app->params['b2bHost'],
            Yii::$app->params['b2bUser'],
            Yii::$app->params['b2bPass']
        );
        $importModel->login('index_old.php');
        //sleep(5);
        $content = $importModel->getContent();

        Yii::$app->session->setFlash('success', 'Категории импортированы');

        $this->redirect(Url::to('/category'));

    }

}