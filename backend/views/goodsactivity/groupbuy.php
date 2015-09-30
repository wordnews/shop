<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = $this->params['meta_title'] . $this->exTitle;

$this->params['breadcrumbs'][] = $this->params['meta_title'];
?>
<div class="goods-activity-index">

    <div class="main_title_wrapper clear">
        <h3><?= Html::encode($this->params['meta_title']) ?></h3>
    
        <p class="action">
            <?= Html::a('添加团购活动', ['addgroupbuy'], ['class' => 'btn btn-success']) ?>
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

            商品名称
            <?= Html::textInput('goods_name', isset($_GET['goods_name']) ? $_GET['goods_name'] : '') ?>
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
                'name' => 'id'
            ],

            'act_id',
            'goods_name',
            [
                'header' => Html::a('状态', 'javascript:;'),
                'content' => function($model){
                    return $model->groupBuyStatus($model);
                }
            ],
            [
                'attribute' => 'end_time',
                'value' => function($model){
                    return date('Y-m-d', $model->end_time);
                }
            ],
            [
                'header' => Html::a('保证金', 'javascript:;'),
                'content' => function($model){
                    $data = unserialize($model->ext_info);
                    return $data['deposit'];
                }
            ],
            [
                'header' => Html::a('限购', 'javascript:;'),
                'content' => function($model){
                    $ext_info = unserialize($model->ext_info);
                    return $ext_info['restrict_amount'];
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Html::a('操作', 'javascript:void(0);'),
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['editgroupbuy', 'id' => $model->act_id], [
                            'title' => Yii::t('yii', '编辑'),
                        ]);
                    },
                    'delete' => function($url, $model, $key){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delgroupbuy', 'id' => $model->act_id], [
                            'title' => Yii::t('yii', 'Delete'),
                            'aria-label' => Yii::t('yii', 'Delete'),
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ]);
                    }
                ]
            ],
        ],
    ]); ?>
    <?php Pjax::end() ?>

</div>
