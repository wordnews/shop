<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;

use common\models\Menu;


$this->title = $this->params['meta_title'] . $this->exTitle;

$this->params['breadcrumbs'][] = $this->params['meta_title'];
?>
<div class="menu-index">
    <?php Pjax::begin() ?>
    <div class="main_title_wrapper clear">
        <h3><?= Html::encode($this->params['meta_title']) ?></h3>

        <p class="action">
            <?= Html::a('创建菜单', ['create', 'pid' => $_GET['pid']], ['class' => 'btn btn-success']) ?>
            <?php
            if ($_GET['pid'] > 0) {
                echo Html::a('返回列表', ['index'], ['class' => 'btn btn-warning']);
            }
            ?>
        </p>
    </div>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'name' => 'menu_id'
            ],

            'menu_id',
            'title',
//            'pid',
            [
                'header' => Html::a('子菜单', 'javascript:void(0);'),
                'content' => function ($model) {

                    $Menu = new Menu();
                    $count = $Menu->itemMenu($model->menu_id);

                    if ($count > 0) {
                        return Html::a($count, ['index', 'pid' => $model->menu_id]);
                    }
                    return Html::a($count, 'javascript:void(0);');;
                }
            ],
            'url',
            'sort',
            [
                'header' => Html::a('状态', 'javascript:void(0);'),
                'content' => function ($model) {
                    if ($model->status == 1) {
                        return Html::img('@web/image/yes.gif', [
                            'onclick' => "setStatus(this, {$model->menu_id})",
                            'data-status' => 0
                        ]);
                    }
                    return Html::img('@web/image/no.gif', [
                        'onclick' => "setStatus(this, {$model->menu_id})",
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
        $.get("<?= Url::to(['status']) ?>", {menu_id:id, status:status}, function(re){
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
