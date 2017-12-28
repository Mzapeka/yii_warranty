<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 25.12.17
 * Time: 14:41
 */

namespace backend\controllers;


use backend\modules\catalogManager\models\B2bPortal;
use site\entities\Catalog\Category;
use site\services\category\CategoryService;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;

class CategoryController extends Controller
{

    private $service;

    public function __construct($id, $module, CategoryService $service, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function actionIndex()
    {
        $category = Category::find()->addOrderBy('root, lft');
        return $this->render('index',[
            'query' => $category,
        ]);
    }

    public function actionCatalogImport(){
        $importModel = new B2bPortal(
            Yii::$app->params['b2bHost'],
            Yii::$app->params['b2bUser'],
            Yii::$app->params['b2bPass']
        );
        $categoriesArray = $importModel->getCategories('index_old.php');
        $result = $this->service->importCategories($categoriesArray);

        Yii::$app->session->setFlash('success', $this->renderPartial('importResult', [
            'result' => $result
        ]));

        $this->redirect(Url::to('/category'));

    }

}