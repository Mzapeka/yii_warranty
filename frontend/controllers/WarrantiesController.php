<?php

namespace frontend\controllers;

use frontend\forms\WarrantySearch;
use site\entities\User\User;
use site\forms\warranty\WarrantyCreateFormByUser;
use site\services\warranty\WarrantyService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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

    public function actionCreate()
    {
        $form = new WarrantyCreateFormByUser();
        //var_dump(Yii::$app->request->post());
        //exit;
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try{
                $user = $this->service->create($form);
                return $this->redirect(['view', 'id' => $user->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }


    public function actionView($id)
    {
        try{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }catch (NotFoundHttpException $e){
            return $this->renderContent($e->getMessage());
        }

    }


    protected function findModel($id)
    {
        if (($model = User::findOne(Yii::$app->getUser()->id)->getWarranties()->andFilterwhere(['id'=>$id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрашиваемая страница не найдена');
    }


}
