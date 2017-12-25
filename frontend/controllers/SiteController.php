<?php
namespace frontend\controllers;


use DateTime;
use site\forms\warranty\WarrantyCheck;
use site\services\warranty\WarrantyService;
use Yii;
use yii\helpers\Url;
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
        if(Yii::$app->getUser()->isGuest){
            return $this->render('index');
        }
        return $this->redirect(Url::to('customers'));
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionContact()
    {
        return $this->render('contact');
    }

    public function actionPolicy()
    {
        return $this->render('policy');
    }

    public function actionWarrantyCheck()
    {
        /**@var $date DateTime */
        /**@var $warrantyService WarrantyService */
        $form = new WarrantyCheck();
//todo: проверить работает ли функция проверки гарантии. Был изменен форматы вывода даты с объекта на UNIX
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try{
                $warrantyService = Yii::$container->get(WarrantyService::class);
                $date = $warrantyService->getWarrantyBySerialNumber($form->warrantyNumber)->getWarrantyValidUntil();
                Yii::$app->session->setFlash('success',
                    'Гарантия действительна до '.Yii::$app->formatter->format($date,'date'));
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
