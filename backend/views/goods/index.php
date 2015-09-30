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
            <?= Html::a('添加新商品', ['create'], ['class' => 'btn btn-success']) ?>
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

            <?= Html::decode(Html::dropDownList('cat_id', $_GET['cat_id'], $categoryList)) ?>

            <?= Html::decode(Html::dropDownList('brand_id', $_GET['brand_id'], $brandList)) ?>

            <!-- 推荐 -->
            <?= Html::decode(Html::dropDownList('intro_type', $_GET['intro_type'], [
                'is_all' => '全部',
                'is_best' => '精品',
                'is_new' => '新品',
                'is_hot' => '热销',
                'is_promote' => '特价'
            ])) ?>

            <?= Html::decode(Html::dropDownList('is_on_sale', $_GET['is_on_sale'], [
                '' => '全部',
                '1' => '上架',
                '0' => '下架'
            ])) ?>

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
                'name' => 'id'
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
                'header' => Html::a('上架', 'javascript:;'),
                'content' => function ($model) {

                    if ($model->is_on_sale == 1) {
                        return Html::img('@web/image/yes.gif', [
                            'onclick' => "setOnSale(this, {$model->goods_id})",
                            'data-status' => 0
                        ]);
                    }
                    return Html::img('@web/image/no.gif', [
                        'onclick' => "setOnSale(this, {$model->goods_id})",
                        'data-status' => 1
                    ]);
                }
            ],
            [
                'header' => Html::a('精品', 'javascript:;'),
                'content' => function ($model) {

                    if ($model->is_best == 1) {
                        return Html::img('@web/image/yes.gif', [
                            'onclick' => "setBest(this, {$model->goods_id})",
                            'data-status' => 0
                        ]);
                    }
                    return Html::img('@web/image/no.gif', [
                        'onclick' => "setBest(this, {$model->goods_id})",
                        'data-status' => 1
                    ]);
                }
            ],
            [
                'header' => Html::a('新品', 'javascript:;'),
                'content' => function ($model) {

                    if ($model->is_new == 1) {
                        return Html::img('@web/image/yes.gif', [
                            'onclick' => "setNew(this, {$model->goods_id})",
                            'data-status' => 0
                        ]);
                    }
                    return Html::img('@web/image/no.gif', [
                        'onclick' => "setNew(this, {$model->goods_id})",
                        'data-status' => 1
                    ]);
                }
            ],
            [
                'header' => Html::a('热销', 'javascript:;'),
                'content' => function ($model) {

                    if ($model->is_hot == 1) {
                        return Html::img('@web/image/yes.gif', [
                            'onclick' => "setHot(this, {$model->goods_id})",
                            'data-status' => 0
                        ]);
                    }
                    return Html::img('@web/image/no.gif', [
                        'onclick' => "setHot(this, {$model->goods_id})",
                        'data-status' => 1
                    ]);
                }
            ],
            'sort_order',
            [
                'header' => Html::a('库存', 'javascript:;'),
                'content' => function ($model) {
                    return $model->goods_number;
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Html::a('操作', 'javascript:void(0);'),
                'template' => '{update} {delete}',
                'buttons' => [
                    'delete' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['remove', 'id' => $model->goods_id], [
                            'title' => Yii::t('yii', '删除'),
                            'data-confirm' => '您确实要把该商品放入回收站吗？',
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

<?php $this->beginBlock('js_end') ?>

function setOnSale(objs, id) {
    var obj = $(objs);
    var status = obj.attr('data-status');
    $.get("<?= Url::to(['sale']) ?>", {goods_id:id, status:status}, function(re){
        if (re == 1) {
            if (status == 1) {
                obj.attr({src:"<?= Url::to('@web/image/yes.gif') ?>", 'data-status':0});

            }else {
                obj.attr({src:"<?= Url::to('@web/image/no.gif') ?>", 'data-status':1});

            }
        }
    });
}

function setBest(objs, id) {
    var obj = $(objs);
    var status = obj.attr('data-status');
    $.get("<?= Url::to(['best']) ?>", {goods_id:id, status:status}, function(re){
        if (re == 1) {
            if (status == 1) {
                obj.attr({src:"<?= Url::to('@web/image/yes.gif') ?>", 'data-status':0});

            }else {
                obj.attr({src:"<?= Url::to('@web/image/no.gif') ?>", 'data-status':1});

            }
        }
    });
}

function setNew(objs, id) {
    var obj = $(objs);
    var status = obj.attr('data-status');
    $.get("<?= Url::to(['new']) ?>", {goods_id:id, status:status}, function(re){
        if (re == 1) {
            if (status == 1) {
                obj.attr({src:"<?= Url::to('@web/image/yes.gif') ?>", 'data-status':0});

            }else {
                obj.attr({src:"<?= Url::to('@web/image/no.gif') ?>", 'data-status':1});

            }
        }
    });
}

function setHot(objs, id) {
    var obj = $(objs);
    var status = obj.attr('data-status');
    $.get("<?= Url::to(['hot']) ?>", {goods_id:id, status:status}, function(re){
        if (re == 1) {
            if (status == 1) {
                obj.attr({src:"<?= Url::to('@web/image/yes.gif') ?>", 'data-status':0});

            }else {
                obj.attr({src:"<?= Url::to('@web/image/no.gif') ?>", 'data-status':1});

            }
        }
    });
}



<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['js_end'], $this::POS_END); ?>

