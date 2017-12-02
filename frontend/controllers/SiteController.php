<?php
namespace frontend\controllers;


use site\forms\warranty\WarrantyCheck;
use site\services\warranty\WarrantyService;
use Yii;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
     /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionContact()
    {
        return $this->render('contact');
    }

    public function actionWarrantyCheck()
    {
        $model = new WarrantyCheck();
        return $this->render('warranty_check',
            [
                'model' => $model,
            ]
        );
    }

    /**@date DateTime */
    public function actionWarrantyCheckAction()
    {
        $form = new WarrantyCheck();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try{
                $warrantyService = Yii::$container->get(WarrantyService::class);
                $date = $warrantyService->warrantyValidUntilBySerialNumber($form->warrantyNumber);
                Yii::$app->session->setFlash('success',
                    'Гарантия действительна до '.Yii::$app->formatter->format($date->format('Y-m-d'),'date'));
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('warranty_check', [
            'model' => $form,
        ]);

    }


}
