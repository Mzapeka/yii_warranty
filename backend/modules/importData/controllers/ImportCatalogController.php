<?php

namespace app\modules\importData\controllers;


use backend\modules\importData\models\catalogManager\B2bPortal;
use site\services\category\CategoryService;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;

/**
* @property B2bPortal $b2bPortal
* @property CategoryService $service
 */

class ImportCatalogController extends Controller
{
    private $service;
    private $b2bPortal;

    public function __construct($id, $module, CategoryService $categoryService, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $categoryService;

        $this->b2bPortal = new B2bPortal(
            Yii::$app->params['b2bHost'],
            Yii::$app->params['b2bUser'],
            Yii::$app->params['b2bPass']
        );
    }
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionImportCategory(){

        $categories = $this->b2bPortal->getCategories('index_old.php');
        $result = $this->service->importCategories($categories);

        Yii::$app->session->setFlash('success', $this->renderPartial('importResult', [
            'result' => $result
        ]));

        $this->redirect(Url::toRoute('/importdata/import-catalog'));
    }

    public function actionImportDocuments()
    {
        $documents = $this->b2bPortal->getDocuments();
        var_dump($documents);
    }

}
