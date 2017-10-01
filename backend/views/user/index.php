<?php

use kartik\date\DatePicker;
use site\access\Rbac;
use site\entities\User\User;
use site\helpers\UserHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\forms\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">


    <?php Pjax::begin();?> <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
      <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    [
                        'attribute' => 'username',
                        'value' => function (User $model) {
                            return Html::a(Html::encode($model->username), ['view', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                    ],
                    //'email:email',
                    [
                        'attribute' => 'status',
                        'filter' => UserHelper::statusList(),
                        'value' => function (User $model) {
                            return UserHelper::statusLabel($model->status);
                        },
                        'format' => 'raw',
                    ],
                    //'company',
                    'adress',
                    'phone',
                    [
                        'attribute' => 'group',
                        'filter' => $searchModel->rolesList(),
                        'value' => function(User $model){
                            $class = '';
                            $roles = ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description');
                            switch ($model->group){
                                case Rbac::ROLE_DEALER:
                                   $class = 'label label-success';
                                   break;
                                case Rbac::ROLE_ADMIN:
                                    $class = 'label label-danger';
                                    break;
                                case Rbac::ROLE_GUEST:
                                    $class = 'label label-primary';
                                    break;
                                default:
                                    $class = 'label label-default';
                                    break;
                            }
                            $userRole = $roles[$model->group];
                           return \yii\bootstrap\Html::tag('span', $userRole, ['class'=>$class,]);
                        },
                        'format' => 'raw',

                    ],
                    [
                        'attribute' => 'created_at',
                        'filter' => DatePicker::widget([
                            'model' => $searchModel,
                            'attribute' => 'date_from',
                            'attribute2' => 'date_to',
                            'type' => DatePicker::TYPE_RANGE,
                            'separator' => '-',
                            'pluginOptions' => [
                                'todayHighlight' => true,
                                'autoclose'=>true,
                                'format' => 'yyyy-mm-dd',
                            ],
                        ]),
                        'format' => 'datetime',
                    ],
                    //'updated_at',

                    ////'auth_key',
                    //'password_hash',
                    //'password_reset_token',

                    // 'email_confirm_token:email',


                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
    <?php Pjax::end();?>
</div>
