<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = $this->params['meta_title'] . $this->exTitle;

$this->params['breadcrumbs'][] = $this->params['meta_title'];
?>
<div class="member-rank-index">

    <div class="main_title_wrapper clear">
        <h3><?= Html::encode($this->params['meta_title']) ?></h3>
    
        <p class="action">
            <?= Html::a('添加会员等级', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    </div>

    <?php Pjax::begin() ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'rank_name',
            'min_points',
            'max_points',
            'discount',
            [
                'attribute' => 'special_rank',
                'content' => function ($model) {
                    if ($model->special_rank == 1) {
                        return Html::img('@web/image/yes.gif', [
                            'onclick' => "setSpecialrank(this, {$model->rank_id})",
                            'data-status' => 0
                        ]);
                    } else {
                        return Html::img('@web/image/no.gif', [
                            'onclick' => "setSpecialrank(this, {$model->rank_id})",
                            'data-status' => 1
                        ]);
                    }
                }
            ],
            [
                'header' => Html::a('显示价格', 'javascript:;'),
                'content' => function ($model) {
                    if ($model->show_price == 1) {
                        return Html::img('@web/image/yes.gif', [
                            'onclick' => "setShowPrice(this, {$model->rank_id})",
                            'data-status' => 0
                        ]);
                    } else {
                        return Html::img('@web/image/no.gif', [
                            'onclick' => "setShowPrice(this, {$model->rank_id})",
                            'data-status' => 1
                        ]);
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

<?php $this->beginBlock('js_end') ?>

function setShowPrice(objs, id){
    var obj = $(objs);
    var status = obj.attr('data-status');
    $.get("<?= Url::to(['showprice']) ?>", {rank_id:id, status:status}, function(re){
        if (re == 1) {
            if (status == 1) {
                obj.attr({src:"<?= Url::to('@web/image/yes.gif') ?>", 'data-status':0});

            }else {
                obj.attr({src:"<?= Url::to('@web/image/no.gif') ?>", 'data-status':1});

            }
        }
    });
}

function setSpecialrank(objs, id){
    var obj = $(objs);
    var status = obj.attr('data-status');
    $.get("<?= Url::to(['specialrank']) ?>", {rank_id:id, status:status}, function(re){
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