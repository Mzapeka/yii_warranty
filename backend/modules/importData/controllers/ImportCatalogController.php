<?php

namespace app\modules\importData\controllers;



use common\modules\catalogManager\B2bPortal;
use site\services\category\CategoryService;
use site\services\item\ItemService;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;

/**
* @property B2bPortal $b2bPortal
* @property CategoryService $categoryService
* @property ItemService $itemService
 */

class ImportCatalogController extends Controller
{
    private $categoryService;
    private $itemService;
    private $b2bPortal;

    public function __construct($id, $module, CategoryService $categoryService, ItemService $itemService, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->categoryService = $categoryService;
        $this->itemService = $itemService;

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

        $categories = $this->b2bPortal->getCategories();
        $result = $this->categoryService->importCategories($categories);

        Yii::$app->session->setFlash('success', $this->renderPartial('importResult', [
            'result' => $result
        ]));

        $this->redirect(Url::toRoute('/importdata/import-catalog'));
    }

    public function actionImportDocuments()
    {
        $documents = $this->b2bPortal->getDocuments();
        $result = $this->itemService->importDocuments($documents);

        Yii::$app->session->setFlash('success', $this->renderPartial('importDocuments', [
            'result' => $result
        ]));

        $this->redirect(Url::toRoute('/importdata/import-catalog'));
        //todo: доделать вывод флеш сообщения
    }

}
