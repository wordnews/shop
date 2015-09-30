<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\helpers\Functions;

$this->title = $this->params['meta_title'] . $this->exTitle;

$this->params['breadcrumbs'][] = $this->params['meta_title'];
?>
<div class="goods-index">

    <div class="main_title_wrapper clear">
        <h3><?= Html::encode($this->params['meta_title']) ?></h3>
    
        <p class="action">
            <?= Html::a('商品列表', ['index'], ['class' => 'btn btn-success']) ?>
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

            商品关键字
            <?= Html::textInput('goods_name', $_GET['goods_name']) ?>
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
                'options' => [
                    'width' => 50
                ]
            ],

            [
                'attribute' => 'goods_id',
                'value' => function ($model) {
                    return $model->goods_id;
                },
                'options' => [
                    'width' => 20
                ]
            ],
            [
                'attribute' => 'goods_name',
                'value' => function ($model) {
                    return Functions::truncate_utf8_string($model->goods_name, 20);
                }
            ],
            [
                'attribute' => 'goods_sn',
                'value' => function ($model) {
                    return $model->goods_sn;
                },
                'options' => [
                    'width' => 100
                ]
            ],
            [
                'attribute' => 'shop_price',
                'value' => function ($model) {
                    return $model->shop_price;
                },
                'options' => [
                    'width' => 100
                ]
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Html::a('操作', 'javascript:void(0);'),
                'template' => '{restore} {delete}',
                'buttons' => [
                    'restore' => function ($url, $model, $key) {
                        return Html::a('还原', $url, [
                            'title' => Yii::t('yii', '删除'),
                            'data-confirm' => '您确实要把该商品还原吗？',
                            'data-method' => 'post',
                        ]);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('删除', $url, [
                            'title' => Yii::t('yii', '删除'),
                            'data-confirm' => '您确定要彻底删除此商品吗？',
                            'data-method' => 'post',
                            'data-pjax' => '0'
                        ]);
                    },
                ]
            ],
        ],
    ]); ?>
    <?php Pjax::end() ?>

</div>


