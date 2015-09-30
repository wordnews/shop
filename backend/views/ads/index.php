<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\AdPosition;

$this->title = $this->params['meta_title'] . $this->exTitle;

$this->params['breadcrumbs'][] = $this->params['meta_title'];
?>
<div class="ad-index">

    <div class="main_title_wrapper clear">
        <h3><?= Html::encode($this->params['meta_title']) ?></h3>
    
        <p class="action">
            <?= Html::a('添加广告', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    </div>

    <?php Pjax::begin() ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'ad_name',
            [
                'header' => Html::a('广告位置', 'javascript:void(0);'),
                'content' => function ($model) {
                    if ($model->position_id < 1) {
                        return '站外广告';
                    }
                    return AdPosition::findOne($model->position_id)->position_name;
                }
            ],

            [
                'header' => Html::a('媒介类型', 'javascript:void(0);'),
                'content' => function ($model) {
                    switch ($model->media_type) {
                        case 0:
                            return '图片';
                        case 1:
                            return 'Flash';
                        case 2:
                            return '代码';
                        case 3:
                            return '文字';
                    }
                }
            ],
            [
                'attribute' => 'start_time',
                'value' => function($model){
                    if ($model->start_time > 0) {
                        return date('Y-m-d', $model->start_time);
                    }
                }
            ],
            [
                'attribute' => 'end_time',
                'value' => function($model){
                    if ($model->end_time > 0) {
                        return date('Y-m-d', $model->end_time);
                    }
                }
            ],

            [
                'header' => Html::a('是否开启', 'javascript:void(0);'),
                'content' => function ($model) {
                    if ($model->enabled == 1) {
                        return Html::img('@web/image/yes.gif', [
                            'onclick' => "setEnabled(this, {$model->ad_id})",
                            'data-status' => 0
                        ]);
                    }
                    return Html::img('@web/image/no.gif', [
                        'onclick' => "setEnabled(this, {$model->ad_id})",
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

function setEnabled(objs, id){
    var obj = $(objs);
    var status = obj.attr('data-status');
    $.get("<?= Url::to(['enabled']) ?>", {ad_id:id, status:status}, function(re){
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
