<?php

namespace frontend\controllers;

use site\entities\Catalog\Category;
use site\repositories\CategoryRepository;
use site\repositories\ItemRepository;
use site\repositories\NotFoundException;
use Yii;
use yii\web\Controller;

class ManualsController extends Controller
{
    public $layout = '@app/views/layouts/manager/main.php';
    private $documents;
    private $categories;

    public function __construct(
        $id,
        $module,
        ItemRepository $documents,
        CategoryRepository $categories,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->documents = $documents;
        $this->categories = $categories;
    }

    public function actionIndex()
    {
        $dataProvider = $this->documents->getAll();
        $category = $this->categories->getRoot();

        return $this->render('index', [
            'category' => $category,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function actionCategory($id)
    {
        $dataProvider = null;
        if (!$category = $this->categories->find($id)) {
            Yii::$app->session->setFlash('error', 'Запрошеная страница не существует.');
        }else{
            $dataProvider = $this->documents->getAllByCategory($category);
        }

        return $this->render('index', [
            'category' => $category,
            'dataProvider' => $dataProvider,
        ]);
    }

}
