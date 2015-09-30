<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;


$this->title = $this->params['meta_title'] . $this->exTitle;
$this->params['breadcrumbs'][] = $this->params['meta_title'];
?>
<div class="friend-link-index">

    <div class="main_title_wrapper clear">
        <h3><?= Html::encode($this->params['meta_title']) ?></h3>

        <p class="action">
            <?= Html::a('添加新链接', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    </div>

    <?php Pjax::begin() ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'name' => 'link_id'
            ],

            'link_id',
            'link_name',
            'link_url:url',
            [
                'header' => Html::a('链接LOGO', 'javascript:void(0);'),
                'content' => function ($model) {
                    if ($model->link_logo) {
                        return Html::img('@web/' . $model->link_logo, [
                            'width' => 50,
                            'height' => 50
                        ]);
                    }
                }
            ],
            'show_order',
            [
                'header' => Html::a('状态', 'javascript:void(0);'),
                'content' => function ($model) {
                    if ($model->status == 1) {
                        return Html::img('@web/image/yes.gif', [
                            'onclick' => "setStatus(this, {$model->link_id})",
                            'data-status' => 0
                        ]);
                    }
                    return Html::img('@web/image/no.gif', [
                        'onclick' => "setStatus(this, {$model->link_id})",
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
    $.get("<?= Url::to(['status']) ?>", {link_id:id, status:status}, function(re){
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
