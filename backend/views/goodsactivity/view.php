<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\GoodsActivity */

$this->title = $model->act_id;
$this->params['breadcrumbs'][] = ['label' => 'Goods Activities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-activity-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->act_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->act_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'act_id',
            'act_name',
            'act_desc:ntext',
            'act_type',
            'goods_id',
            'product_id',
            'goods_name',
            'start_time:datetime',
            'end_time:datetime',
            'is_finished',
            'ext_info:ntext',
        ],
    ]) ?>

</div>
