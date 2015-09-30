<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\GoodsType;
use common\helpers\Functions;

$this->title = $this->params['meta_title'] . $this->exTitle;

$this->params['breadcrumbs'][] = $this->params['meta_title'];
?>
<div class="attribute-index">

    <div class="main_title_wrapper clear">
        <h3><?= Html::encode($this->params['meta_title']) ?></h3>
    
        <p class="action">
            <?= Html::a('添加属性', ['create'], ['class' => 'btn btn-success']) ?>
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
            按商品类型显示：

            <?= Html::decode(Html::dropDownList('cat_id', $_GET['cat_id'], $dropList)) ?>

            <input type="submit" value=" 搜索 " class="button">

        </form>

    </div>

    <?= Html::beginForm(['deleteall']) ?>
    <?php Pjax::begin() ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'showFooter' => true,
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'name' => 'id',
                'footer' => Html::button('批量删除', [
                    'class' => 'btn btn-danger',
                    'onclick' => 'submits()'
                ]),
                'options' => [
                    'width' => 70
                ]
            ],

            'attr_id',
            [
                'header' => Html::a('商品类型', 'javascript:;'),
                'content' => function ($model) {
                    return GoodsType::findOne($model->cat_id)->cat_name;
                },
            ],
            'attr_name',
            [
                'header' => Html::a('录入方式', 'javascript:;'),
                'content' => function ($model) {
                    $typeList = [
                        '0' => '手工录入',
                        '1' => '从列表中选择',
                        '2' => '多行文本框'
                    ];
                    return $typeList[$model->attr_input_type];
                }
            ],
            [
                'attribute' => 'attr_values',
                'value' => function ($model) {
                    $content = str_replace("\r\n", ', ', $model->attr_values);
                    return Functions::truncate_utf8_string($content, 28);
                },
                'options' => [
                    'width' => 430
                ]
            ],
            [
                'attribute' => 'sort_order',
                'value' => function ($model) {
                    return $model->sort_order;
                },
                'options' => [
                    'width' => 70
                ]
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Html::a('操作', 'javascript:void(0);'),
                'template' => '{update} {delete} {deletes}',
            ],
        ],


    ]); ?>
    <?php Pjax::end() ?>
    <?= Html::endForm() ?>

</div>
<script>
function submits(){
    if (confirm('您确定要删除选中项吗？')) {
        $('form').submit();
    }
}
</script>