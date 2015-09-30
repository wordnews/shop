<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = $this->params['meta_title'] . $this->exTitle;

$this->params['breadcrumbs'][] = $this->params['meta_title'];
?>
<div class="goods-type-index">

    <div class="main_title_wrapper clear">
        <h3><?= Html::encode($this->params['meta_title']) ?></h3>
    
        <p class="action">
            <?= Html::a('新建商品类型', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    </div>

    <?php Pjax::begin() ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'cat_name',
            [
                'header' => Html::a('属性分组', 'javascript:;'),
                'content' => function ($model) {
                    return str_replace("\r\n", ', ', $model->attr_group);
                }
            ],

            [
                'header' => Html::a('状态', 'javascript:void(0);'),
                'content' => function ($model) {
                    if ($model->enabled == 1) {
                        return Html::img('@web/image/yes.gif', [
                            'onclick' => "setEnabled(this, {$model->cat_id})",
                            'data-status' => 0
                        ]);
                    }
                    return Html::img('@web/image/no.gif', [
                        'onclick' => "setEnabled(this, {$model->cat_id})",
                        'data-status' => 1
                    ]);
                }
            ],


            /*[
                'class' => 'yii\grid\ActionColumn',
                'header' => Html::a('操作', 'javascript:void(0);'),
                'template' => '{update} {delete}',
            ],*/
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Html::a('操作', 'javascript:void(0);'),
                'template' => '{attribute} {update} {delete}',
                'buttons' => [
                    'attribute' => function ($url, $model, $key) {
                        return Html::a('属性列表', ['attribute/index', 'cat_id' => $model->cat_id], [
                            'title' => Yii::t('yii', '属性列表'),
                        ]);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('编辑', $url, [
                            'title' => Yii::t('yii', '编辑'),
                        ]);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('删除', $url, [
                            'title' => Yii::t('yii', '删除'),
                            'data-confirm' => '您确定要删除此项吗？',
                            'data-method' => 'post',
                            'data-pjax' => '0'
                        ]);
                    },
                ],
                'options' => [
                    'width' => 200
                ]
            ],
        ],
    ]); ?>
    <?php Pjax::end() ?>

</div>

<?php $this->beginBlock('js_end') ?>

function setEnabled(objs, id){
    var obj = $(objs);
    var status = obj.attr('data-status');
    $.get("<?= Url::to(['enabled']) ?>", {act_id:id, status:status}, function(re){
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
