<?php



/* @var $this yii\web\View */

use yii\widgets\DetailView;

/* @var $model site\entities\Customer\Customer */

$this->title = $model->customer_name;
$this->params['breadcrumbs'][] = ['label' => 'Клиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-view">

    <h1><?=$this->title?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'customer_name',
            'adress',
            'phone',
            'email:email',
            'created_at:datetime',
        ],
    ]) ?>

</div>
