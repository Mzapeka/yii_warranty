<?php

namespace frontend\controllers;

use common\modules\catalogManager\B2bPortal;
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

    public function actionDocument($id)
    {
        /**
         * @var B2bPortal $b2bPortal
        */
        //todo:сделать логику вывода файла с локального хранилища
        $document = $this->documents->findById($id);
        $b2bPortal = Yii::$container->get(B2bPortal::class);
        $this->outputDocument($b2bPortal->getDocumentContent($document->old_id), $document->file_type);
        //echo iconv('windows-1251', 'utf8', $b2bPortal->getDocumentContent($id));
    }

    protected function outputDocument($document, $fileType){
        // Send PDF to the standard output
        if (ob_get_contents()) {
            echo 'Some data has already been output, can\'t send PDF file';
        }
        if (php_sapi_name() != 'cli') {
            // send output to a browser
            header('Content-Type: application/'.$fileType);
            if (headers_sent()) {
                echo 'Some data has already been output to browser, can\'t send PDF file';
            }
            header('Cache-Control: private, must-revalidate, post-check=0, pre-check=0, max-age=1');
            //header('Cache-Control: public, must-revalidate, max-age=0'); // HTTP/1.1
            header('Pragma: public');
            header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
            header('Content-Disposition: inline; filename="document.'.$fileType.'"');
            echo $document;
        } else {
            echo $document;
        }
    }

}
