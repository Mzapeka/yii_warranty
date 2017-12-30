<?php

namespace app\modules\importData\controllers;


use backend\modules\importData\models\catalogManager\B2bPortal;
use site\services\category\CategoryService;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;


class ImportCatalogController extends Controller
{
    private $service;

    public function __construct($id, $module, CategoryService $categoryService, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $categoryService;
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
        $b2bPortal = self::getB2bPortal();
        $categories = $b2bPortal->getCategories('index_old.php');
        $result = $this->service->importCategories($categories);

        Yii::$app->session->setFlash('success', $this->renderPartial('importResult', [
            'result' => $result
        ]));

        $this->redirect(Url::toRoute('/importdata/import-catalog'));
    }

    public function actionImportDocuments()
    {
        $b2bPortal = self::getB2bPortal();
        $documents = $b2bPortal->getDocuments();
        var_dump($documents);
    }

    protected static function getB2bPortal():B2bPortal
    {
        return new B2bPortal(
            Yii::$app->params['b2bHost'],
            Yii::$app->params['b2bUser'],
            Yii::$app->params['b2bPass']
        );
    }

}
