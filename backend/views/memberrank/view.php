<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\MemberRank */

$this->title = $model->rank_id;
$this->params['breadcrumbs'][] = ['label' => 'Member Ranks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="member-rank-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->rank_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->rank_id], [
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
            'rank_id',
            'rank_name',
            'min_points',
            'max_points',
            'discount',
            'show_price',
            'special_rank',
        ],
    ]) ?>

</div>
