<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = $this->params['meta_title'] . $this->exTitle;

$this->params['breadcrumbs'][] = $this->params['meta_title'];
?>
<div class="category-index">

    <div class="main_title_wrapper clear">
        <h3><?= Html::encode($this->params['meta_title']) ?></h3>
    
        <p class="action">
            <?= Html::a('添加分类', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    </div>


    <div id="w0" class="grid-view">

        <table class="table table-striped table-bordered">
            <thead>
            <tr>

                <th>
                    <a href="javascript:">
                        文章分类名称
                    </a>
                </th>
                <th>
                    <a href="javascript:">
                        商品数量
                    </a>
                </th>
                <th>
                    <a href="javascript:">
                        数量单位
                    </a>
                </th>
                <th width="130">
                    <a href="javascript:">
                        是否显示在导航栏
                    </a>
                </th>

                <th>
                    <a href="javascript:">
                        是否显示
                    </a>
                </th>

                <th>
                    <a href="javascript:">
                        价格区间个数
                    </a>
                </th>

                <th>
                    <a href="javascript:">
                        排序
                    </a>
                </th>

                <th>
                    <a href="javascript:">
                        操作
                    </a>
                </th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($list as $val): ?>
                <tr>

                    <td>
                        <?= $val['cat_name'] ?>
                    </td>
                    <td>
                        <?= '待完善' ?>
                    </td>
                    <td>
                        <?= $val['measure_unit'] ?>
                    </td>
                    <td>
                        <?= $val['show_in_nav'] ? Html::img('@web/image/yes.gif', [
                            'onclick' => "setNavs(this, {$val['cat_id']})",
                            'data-status' => 0
                        ]) : Html::img('@web/image/no.gif', [
                            'onclick' => "setNavs(this, {$val['cat_id']})",
                            'data-status' => 1
                        ])  ?>
                    </td>
                    <td>
                        <?= $val['is_show'] ? Html::img('@web/image/yes.gif', [
                            'onclick' => "status(this, {$val['cat_id']})",
                            'data-status' => 0
                        ]) : Html::img('@web/image/no.gif', [
                            'onclick' => "status(this, {$val['cat_id']})",
                            'data-status' => 1
                        ])  ?>
                    </td>

                    <td>
                        <?= $val['grade'] ?>
                    </td>
                    <td>
                        <?= $val['sort_order'] ?>
                    </td>


                    <td>
                        <a href="<?= Url::to(['update', 'id' => $val['cat_id']]) ?>" title="更新" data-pjax="0">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </a>
                        <a href="<?= Url::to(['delete', 'id' => $val['cat_id']]) ?>" title="删除" data-confirm="您确定要删除此项吗？" data-method="post" data-pjax="0">
                            <span class="glyphicon glyphicon-trash"></span>
                        </a>
                    </td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>

    </div>

</div>

<script>
    <?php $this->beginBlock('js_end') ?>

    function setNavs(objs, id){
        var obj = $(objs);
        var status = obj.attr('data-status');
        $.get("<?= Url::to(['setnav']) ?>", {cat_id:id, status:status}, function(re){
            if (re == 1) {
                if (status == 1) {
                    obj.attr({src:"<?= Url::to('@web/image/yes.gif') ?>", 'data-status':0});

                }else {
                    obj.attr({src:"<?= Url::to('@web/image/no.gif') ?>", 'data-status':1});

                }
            }
        });
    }

    function status(objs, id){
        var obj = $(objs);
        var status = obj.attr('data-status');
        $.get("<?= Url::to(['status']) ?>", {cat_id:id, status:status}, function(re){
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
