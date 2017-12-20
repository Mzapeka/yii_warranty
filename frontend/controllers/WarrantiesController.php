<?php

namespace frontend\controllers;

use common\modules\PdfWarranty;
use frontend\forms\WarrantySearch;
use site\entities\User\User;
use site\entities\Warranty\Warranty;
use site\forms\warranty\WarrantyCreateFormByUser;
use site\helpers\CustomerHelper;
use site\services\warranty\WarrantyService;
use Yii;
use yii\bootstrap\ActiveForm;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

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
        //var_dump($_POST);
        //exit;

        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if($form->load(Yii::$app->request->post())){
            if(!CustomerHelper::isCustomerBelongToUser($form->customer_id)){
                return $this->renderContent('Клиент с таким ID не найден');
            }

            $form->status = Warranty::STATUS_ACTIVE;

/*            if(preg_match("/^[\d\+]+$/",$form->invoice_date) && $form->invoice_date > 0){
                $form->invoice_date = date('Y-m-d', $form->invoice_date);
            }
            if(preg_match("/^[\d\+]+$/",$form->act_date) && $form->act_date > 0){
                $form->invoice_date = date('Y-m-d', $form->act_date);
            }*/

/*            var_dump($form->validate());
            exit;*/

            if ($form->validate()) {
                try{
                    $user = $this->service->create($form);
                    return $this->redirect(['view', 'id' => $user->id]);
                } catch (\DomainException $e) {
                    Yii::$app->errorHandler->logException($e);
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
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

    public function actionPrintWarranty($id)
    {
        try{
            $warranty = $this->findModel($id);

            PdfWarranty::instance()->setWarranty($warranty);
            PdfWarranty::instance()->createWarrSheet();

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
