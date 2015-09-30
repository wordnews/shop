<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = $this->params['meta_title'] . $this->exTitle;

$this->params['breadcrumbs'][] = $this->params['meta_title'];
?>
<div class="member-index">

    <div class="main_title_wrapper clear">
        <h3><?= Html::encode($this->params['meta_title']) ?></h3>
    
        <p class="action">
            <?= Html::a('添加会员', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    </div>

    <!-- 搜索 begin -->
    <div class="form-div">
        <form action="">
            <?= Html::img('@web/image/icon_search.gif', [
                'width' => 26,
                'height' => 22,
                'border' => 0,
                'alt' => ''
            ]) ?>

            会员等级
            <?= Html::dropDownList('rank_id', Yii::$app->request->get('rank_id'), $memberRank) ?>

            积分大于
            <?= Html::textInput('min_points', Yii::$app->request->get('min_points'), [
                'style' => 'width : 90px'
            ]) ?>

            积分小于
            <?= Html::textInput('mix_points', Yii::$app->request->get('mix_points'), [
                'style' => 'width : 90px'
            ]) ?>

            会员名称
            <?= Html::textInput('user_name', Yii::$app->request->get('user_name')) ?>

            <input type="submit" value=" 搜索 " class="button">

        </form>
    </div>
    <!-- 搜索 end -->

    <?php Pjax::begin() ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'name' => 'id',
                'options' => ['width' => 30]
            ],

            'user_id',
            'user_name',
            'email',
            [
                'header' => Html::a('是否已验证', 'javascript:;'),
                'content' => function ($model) {
                    if ($model->is_validated == 1) {
                        return Html::img('@web/image/yes.gif', [
                            'onclick' => "setOnSale(this, {$model->user_id})",
                            'data-status' => 0
                        ]);
                    } else {
                        return Html::img('@web/image/no.gif', [
                            'onclick' => "setOnSale(this, {$model->user_id})",
                            'data-status' => 1
                        ]);
                    }
                }
            ],
            'user_money',
            'frozen_money',
            'rank_points',
            'pay_points',
            [
                'attribute' => 'reg_time',
                'value' => function($model) {
                    if ($model->reg_time > 0) {
                        return date('Y-m-d', $model->reg_time);
                    } else {
                        return '';
                    }
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Html::a('操作', 'javascript:void(0);'),
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>
    <?php Pjax::end() ?>

</div>
