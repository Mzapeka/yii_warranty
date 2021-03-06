<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 25.12.17
 * Time: 14:41
 */

namespace backend\controllers;


use backend\modules\catalogManager\models\B2bPortal;
use site\entities\Catalog\Category;
use site\services\category\CategoryService;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;

class CategoryController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $category = Category::find()->addOrderBy('root, lft');
        return $this->render('index',[
            'query' => $category,
        ]);
    }

}