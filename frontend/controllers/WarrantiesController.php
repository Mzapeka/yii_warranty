<?php

namespace frontend\controllers;

use frontend\forms\WarrantySearch;
use site\services\warranty\WarrantyService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;

class WarrantiesController extends Controller
{
    public $layout = '@app/views/layouts/manager/main.php';

    private $service;

    public function __construct($id, $module, WarrantyService $service, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        $searchModel = new WarrantySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}
