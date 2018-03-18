<?php

namespace backend\controllers;

use site\forms\warranty\WarrantySettingsEditForm;
use site\services\warranty\WarrantySettingsService;
use Yii;
use site\entities\Warranty\WarrantySettings;
use backend\forms\WarrantySettingsSearch;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * WarrantySettingsController implements the CRUD actions for WarrantySettings model.
 */
class WarrantySettingsController extends Controller
{

    private $service;

    public function __construct($id, $module, WarrantySettingsService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'update', 'view'],
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all WarrantySettings models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => WarrantySettings::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WarrantySettings model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * Updates an existing WarrantySettings model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $form = new WarrantySettingsEditForm($model);
        //var_dump(Yii::$app->request->post());
            if ($form->load(Yii::$app->request->post(), 'WarrantySettings') && $form->validate()) {
                    try{
                       $this->service->edit($id, $form);
                        if (isset($_POST['hasEditable'])) {
                            Yii::$app->response->format = Response::FORMAT_JSON;
                            return ['output' => $form->value, 'message' => ''];
                        }
                        return $this->redirect(['view', 'id' => $id]);
                    }catch (\DomainException $e){
                       Yii::$app->errorHandler->logException($e);
                        Yii::$app->session->setFlash('error', $e->getMessage());
                    }
            }
        return $this->render('update', [
            'form' => $form,
            'model' => $model,
        ]);
    }


    /**
     * Finds the WarrantySettings model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return WarrantySettings the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WarrantySettings::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }



}
