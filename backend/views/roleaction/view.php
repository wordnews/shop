<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\RoleAction */

$this->title = $model->action_id;
$this->params['breadcrumbs'][] = ['label' => 'Role Actions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-action-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->action_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->action_id], [
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
            'action_id',
            'parent_id',
            'action_code',
            'action_title',
        ],
    ]) ?>

</div>
