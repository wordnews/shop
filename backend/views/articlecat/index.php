<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

$listType = [
    '1' => '普通分类',
    '2' => '系统分类',
    '3' => '网店信息',
    '4' => '帮助分类',
    '5' => '网店帮助'
];

$this->title = $this->params['meta_title'] . $this->exTitle;

$this->params['breadcrumbs'][] = $this->params['meta_title'];
?>
<div class="article-cat-index">

    <div class="main_title_wrapper clear">
        <h3><?= Html::encode($this->params['meta_title']) ?></h3>
    
        <p class="action">
            <?= Html::a('添加文章分类', ['create'], ['class' => 'btn btn-success']) ?>
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
                        分类类型
                    </a>
                </th>
                <th>
                    <a href="javascript:">
                        描述
                    </a>
                </th>
                <th>
                    <a href="javascript:">
                        排序
                    </a>
                </th>

                <th>
                    <a href="javascript:">
                        是否显示在导航栏
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
                        <?= $listType[$val['cat_type']] ?>
                    </td>
                    <td>
                        <?= $val['cat_desc'] ?>
                    </td>
                    <td>
                        <?= $val['sort_order'] ?>
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

<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['js_end'], $this::POS_END); ?>
