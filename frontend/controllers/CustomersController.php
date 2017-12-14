<?php

namespace frontend\controllers;

use frontend\forms\CustomersSearch;
use site\entities\Customer\Customer;
use site\entities\User\User;
use site\forms\customer\CustomerCreateForm;
use site\services\customer\CustomerService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CustomersController extends Controller
{
    public $layout = '@app/views/layouts/manager/main.php';

    private $service;

    public function __construct($id, $module, CustomerService $service, array $config = [])
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
        $searchModel = new CustomersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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

    /**
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new CustomerCreateForm();

        if($form->load(Yii::$app->request->post())) {
            $form->dealer_id = Yii::$app->getUser()->id;
            if ($form->validate()) {
                try {
                    $customer = $this->service->create($form);
                    return $this->redirect(['view', 'id' => $customer->id]);
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

    /**
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(Yii::$app->getUser()->id)->getCustomer()->andFilterwhere(['id'=>$id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрашиваемая страница не найдена');
    }

}
