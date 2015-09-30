<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = $this->params['meta_title'] . $this->exTitle;

$this->params['breadcrumbs'][] = $this->params['meta_title'];
?>
<div class="nav-index">

    <div class="main_title_wrapper clear">
        <h3><?= Html::encode($this->params['meta_title']) ?></h3>
    
        <p class="action">
            <?= Html::a('添加导航', ['create'], ['class' => 'btn btn-success']) ?>
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
            导航位置：

            <?= Html::dropDownList('type', $_GET['type'], [
                'all' => '全部',
                'top' => '顶部',
                'middle' => '中间',
                'bottom' => '底部'
            ]) ?>

            <input type="submit" value=" 搜索 " class="button">

        </form>

    </div>

    <?php Pjax::begin() ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'name',
            [
                'header' => Html::a('是否显示', 'javascript:void(0);'),
                'content' => function ($model) {
                    if ($model->ifshow == 1) {
                        return Html::img('@web/image/yes.gif', [
                            'onclick' => "setIfshow(this, {$model->id})",
                            'data-status' => 0
                        ]);
                    }
                    return Html::img('@web/image/no.gif', [
                        'onclick' => "setIfshow(this, {$model->id})",
                        'data-status' => 1
                    ]);
                }
            ],
            [
                'header' => Html::a('是否新窗口打开', 'javascript:void(0);'),
                'content' => function ($model) {
                    if ($model->opennew == 1) {
                        return Html::img('@web/image/yes.gif', [
                            'onclick' => "setOpennew(this, {$model->id})",
                            'data-status' => 0
                        ]);
                    }
                    return Html::img('@web/image/no.gif', [
                        'onclick' => "setOpennew(this, {$model->id})",
                        'data-status' => 1
                    ]);
                }
            ],
            'vieworder',
            [
                'attribute' => 'type',
                'value' => function ($model) {
                    $data = [
                        'top' => '顶部',
                        'middle' => '中间',
                        'bottom' => '底部'
                    ];
                    return $data[$model->type];
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

<script>
    <?php $this->beginBlock('js_end') ?>

    function setIfshow(objs, id){
        var obj = $(objs);
        var status = obj.attr('data-status');
        $.get("<?= Url::to(['ifshow']) ?>", {id:id, status:status}, function(re){
            if (re == 1) {
                if (status == 1) {
                    obj.attr({src:"<?= Url::to('@web/image/yes.gif') ?>", 'data-status':0});

                }else {
                    obj.attr({src:"<?= Url::to('@web/image/no.gif') ?>", 'data-status':1});

                }
            }
        });
    }

    function setOpennew(objs, id){
        var obj = $(objs);
        var status = obj.attr('data-status');
        $.get("<?= Url::to(['opennew']) ?>", {id:id, status:status}, function(re){
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
</script>
