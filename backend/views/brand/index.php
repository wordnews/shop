<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use common\helpers\Functions;
use yii\widgets\Pjax;


$this->title = $this->params['meta_title'] . $this->exTitle;

$this->params['breadcrumbs'][] = $this->params['meta_title'];
?>
<div class="brand-index">

    <div class="main_title_wrapper clear">
        <h3><?= Html::encode($this->params['meta_title']) ?></h3>

        <p class="action">
            <?= Html::a('添加品牌', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    </div>

    <div class="form-div">

        <form action="">

            <?= Html::img('@web/image/icon_search.gif', [
                'width' => 26,
                'height' => 22,
                'border' => 0,
                'alt' => ''
            ]) ?>

            <input type="text" name="brand_name" size="15">

            <input type="submit" value=" 搜索 " class="button">

        </form>

    </div>

    <?php Pjax::begin() ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'brand_name',
            'site_url',
            [
                'header' => Html::a('品牌描述', 'javascript:void(0);'),
                'content' => function ($model) {
                    return Functions::truncate_utf8_string($model->brand_desc, 25);
                }
            ],
//            'brand_desc',

             'sort',
            [
                'header' => Html::a('是否热销', 'javascript:void(0);'),
                'content' => function ($model) {
                    if ($model->is_hot == 1) {
                        return Html::img('@web/image/yes.gif', [
                            'onclick' => "setHot(this, {$model->brand_id})",
                            'data-status' => 0
                        ]);
                    }
                    return Html::img('@web/image/no.gif', [
                        'onclick' => "setHot(this, {$model->brand_id})",
                        'data-status' => 1
                    ]);
                }
            ],
            [
                'header' => Html::a('是否显示', 'javascript:void(0);'),
                'content' => function ($model) {
                    if ($model->status == 1) {
                        return Html::img('@web/image/yes.gif', [
                            'onclick' => "setStatus(this, {$model->brand_id})",
                            'data-status' => 0
                        ]);
                    }
                    return Html::img('@web/image/no.gif', [
                        'onclick' => "setStatus(this, {$model->brand_id})",
                        'data-status' => 1
                    ]);
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

<?php $this->beginBlock('js_end') ?>

function setStatus(objs, id){
    var obj = $(objs);
    var status = obj.attr('data-status');
    $.get("<?= Url::to(['status']) ?>", {brand_id:id, status:status}, function(re){
        if (re == 1) {
            if (status == 1) {
                obj.attr({src:"<?= Url::to('@web/image/yes.gif') ?>", 'data-status':0});

            }else {
                obj.attr({src:"<?= Url::to('@web/image/no.gif') ?>", 'data-status':1});

            }
        }
    });
}

function setHot(objs, id){
    var obj = $(objs);
    var status = obj.attr('data-status');
    $.get("<?= Url::to(['hot']) ?>", {brand_id:id, status:status}, function(re){
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
