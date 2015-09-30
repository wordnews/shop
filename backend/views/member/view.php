<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Member */

$this->title = $model->user_id;
$this->params['breadcrumbs'][] = ['label' => 'Members', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="member-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->user_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->user_id], [
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
            'user_id',
            'email:email',
            'user_name',
            'password',
            'question',
            'answer',
            'sex',
            'birthday',
            'user_money',
            'frozen_money',
            'pay_points',
            'rank_points',
            'address_id',
            'reg_time:datetime',
            'last_login',
            'last_time',
            'last_ip',
            'visit_count',
            'user_rank',
            'is_special',
            'ec_salt',
            'salt',
            'parent_id',
            'flag',
            'alias',
            'msn',
            'qq',
            'office_phone',
            'home_phone',
            'mobile_phone',
            'is_validated',
            'credit_line',
            'passwd_question',
            'passwd_answer',
        ],
    ]) ?>

</div>
