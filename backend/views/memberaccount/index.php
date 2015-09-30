<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Member;

$this->title = $this->params['meta_title'] . $this->exTitle;

$this->params['breadcrumbs'][] = $this->params['meta_title'];
?>
<div class="member-account-index">

    <div class="main_title_wrapper clear">
        <h3><?= Html::encode($this->params['meta_title']) ?></h3>
    
        <p class="action">
            <?= Html::a('添加申请', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    </div>

    <?php Pjax::begin() ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'header' => Html::a('会员名称', 'javascript:;'),
                'content' => function($model){
                    return Member::findOne($model->user_id)->user_name;
                }

            ],
            'add_time:datetime',
            [
                'attribute' => 'process_type',
                'content' => function($model){
                    return $model->processTypeStatus[$model->process_type];
                }
            ],
            'amount',
            'payment',
            [
                'attribute' => 'is_paid',
                'content' => function($model){
                    return $model->isPaidStatus[$model->is_paid];
                }
            ],
            'admin_user',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Html::a('操作', 'javascript:void(0);'),
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        if ($model->is_paid == 0) {
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['checkaccount', 'id' => $model->id], [
                                'title' => '到款审核',
                                'aria-label' => Yii::t('yii', 'Update'),
                            ]);
                        } else {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                'title' => Yii::t('yii', 'Update'),
                                'aria-label' => Yii::t('yii', 'Update'),
                            ]);
                        }
                    },
                    'delete' => function ($url, $model, $key){
                        if ($model->is_paid == 0) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                'title' => Yii::t('yii', 'Delete'),
                                'aria-label' => Yii::t('yii', 'Delete'),
                                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                'data-method' => 'post',
                                'data-pjax' => '0',
                            ]);
                        }
                    }
                ]
            ],
        ],
    ]); ?>
    <?php Pjax::end() ?>

</div>
