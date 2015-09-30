<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\FriendLink */

$this->title = $model->link_id;
$this->params['breadcrumbs'][] = ['label' => 'Friend Links', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="friend-link-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->link_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->link_id], [
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
            'link_id',
            'link_name',
            'link_url:url',
            'link_logo',
            'show_order',
            'status',
        ],
    ]) ?>

</div>
