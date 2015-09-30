<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datetimepicker\DateTimePicker;

$this->title = $this->params['meta_title'] . $this->exTitle;

$this->params['breadcrumbs'][] = ['label' => '团购活动列表', 'url' => ['goodsactivity/groupbuy']];
$this->params['breadcrumbs'][] = $this->params['meta_title'];

/* 活动配置信息 begin */
if ($model->ext_info !== null) {
    $ext_info = unserialize($model->ext_info);
} else {
    $ext_info = ['price_ladder' => [['amount' => '', 'price' => '']]];
}
/* 活动配置信息 end */

?>
<div class="goods-activity-create">

    <div class="main_title_wrapper clear">

        <h3><?= Html::encode($this->params['meta_title']) ?></h3>
        <p class="action">
            <?=Html::a('团购活动列表', ['groupbuy'], ['class' => 'btn btn-success']) ?>
        </p>

    </div>

    <!-- 搜索 begin -->
    <div class="form-div">
        <form action="" onsubmit="return false">
            <?= Html::img('@web/image/icon_search.gif', [
                'width' => 26,
                'height' => 22,
                'border' => 0,
                'alt' => ''
            ]) ?>

            <?= Html::decode(Html::dropDownList('cat_id', $_GET['cat_id'], $categoryList)) ?>

            <?= Html::decode(Html::dropDownList('brand_id', $_GET['brand_id'], $brandList)) ?>

            <?= Html::textInput('goods_name', $_GET['goods_name'], ['class' => 'search-input']) ?>
            <input type="button" value=" 搜索 " onclick="searchGoods()" class="button">
        </form>
    </div>
    <!-- 搜索 end -->

    <div class="goods-activity-form shop-form">

        <?php $form = ActiveForm::begin([
            'options' => [
                'class' => 'form-horizontal',
            ],
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-xs-5\">{input}</div>\n{hint}\n{error}",
            ]
        ]); ?>

        <?= $form->field($model, 'goods_id')->dropDownList($defaultGoods)->label(null, [
            'class' => 'col-sm-2 control-label'
        ]) ?>

        <?php if ($model->start_time > 0) $model->start_time = date('Y-m-d H:i', $model->start_time); ?>
        <?= $form->field($model, 'start_time')->widget(DateTimePicker::className(), [
            'language' => 'zh-CN',
            'size' => 'ms',
            'template' => '{input}',
            'pickButtonIcon' => 'glyphicon glyphicon-time',
            'clientOptions' => [
                'startView' => 2,
                'minView' => 0,
                'maxView' => 5,
                'autoclose' => true,
                'linkFormat' => 'yyyy-mm-dd hh:ii',
                'format' => 'yyyy-mm-dd hh:ii',
                'todayBtn' => false
            ]
        ])->label(null, [
            'class' => 'col-sm-2 control-label'
        ]) ?>

        <?php if ($model->end_time > 0) $model->end_time = date('Y-m-d H:i', $model->end_time); ?>
        <?= $form->field($model, 'end_time')->widget(DateTimePicker::className(), [
            'language' => 'zh-CN',
            'size' => 'ms',
            'template' => '{input}',
            'pickButtonIcon' => 'glyphicon glyphicon-time',
            'clientOptions' => [
                'startView' => 2,
                'minView' => 0,
                'maxView' => 5,
                'autoclose' => true,
                'linkFormat' => 'yyyy-mm-dd hh:ii',
                'format' => 'yyyy-mm-dd hh:ii',
                'todayBtn' => false
            ]
        ])->label(null, [
            'class' => 'col-sm-2 control-label'
        ]) ?>

        <?php $model->deposit = isset($ext_info['deposit']) ? $ext_info['deposit'] : null; ?>
        <?= $form->field($model, 'deposit')->textInput()->label(null, [
            'class' => 'col-sm-2 control-label'
        ]) ?>

        <?php $model->restrict_amount = isset($ext_info['restrict_amount']) ? $ext_info['restrict_amount'] : null; ?>
        <?php if($model->restrict_amount === null) $model->restrict_amount = 0 ?>
        <?= $form->field($model, 'restrict_amount')->textInput()->label(null, [
            'class' => 'col-sm-2 control-label'
        ])->hint('达到此数量，团购活动自动结束。0表示没有数量限制。') ?>

        <?php if($model->gift_integral === null) $model->gift_integral = 0 ?>
        <?= $form->field($model, 'gift_integral')->textInput()->label(null, [
            'class' => 'col-sm-2 control-label'
        ]) ?>

        <?php
            $i = 0;
            foreach ($ext_info['price_ladder'] as $key => $val):
        ?>
        <div role="tabpanel" class="tab-pane shop-pane">
        <div class="form-group">
            <label class="col-sm-2 control-label" >价格阶梯</label>
            <div class="col-xs-5">
                数量达到
                <?= Html::textInput('GoodsActivity[ladder_amount][]', $val['amount'], [
                    'class' => 'form-control',
                    'style' => 'width: 30%; display: inline'
                ]) ?>
                享受价格
                <?= Html::textInput('GoodsActivity[ladder_price][]', $val['price'], [
                    'class' => 'form-control',
                    'style' => 'width: 30%; display: inline'
                ]) ?>
                <?php if ($i == 0){ ?>
                    <a href='javascript:;' onclick='addSpec(this)'>[+]</a>
                <?php } else { ?>
                    <a href='javascript:;' onclick='removeSpec(this)'>[-]</a>
                <?php } $i++; ?>
            </div>
        </div>
        </div>
        <?php endforeach ?>

        <?= $form->field($model, 'act_desc')->textarea(['rows' => 3])->label(null, [
            'class' => 'col-sm-2 control-label'
        ]) ?>

        <div class="form-group">
            <div class="col-xs-2"></div>
            <?= Html::submitButton($model->isNewRecord ? '确 定' : '更 新', ['class' => $model->isNewRecord ? 'btn btn-success word-btn' : 'btn btn-primary word-btn']) ?>
            <?= Html::a('返 回', 'javascript:history.back(-1)', ['class' => 'btn btn-warning']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>

<?php $this->beginBlock('js_end') ?>
/* 节点操作 begin */
// 增加节点
function addSpec(obj)
{
    var tab_pane = $(obj).parents('.tab-pane');
    var content = "<div role=\"tabpanel\" class=\"tab-pane shop-pane\">" + tab_pane .html() + "</div>";

    tab_pane.after(content.replace(/(.*)(addSpec)(.*)(\[)(\+)/i, "$1removeSpec$3$4-"));
}

// 删除节点
function removeSpec(obj)
{
    $(obj).parents('.shop-pane').empty();
}
/* 节点操作 end */

// 搜索商品
function searchGoods(){
    var cat_id = $("select[name=cat_id]").val();
    var brand_id = $("select[name=brand_id]").val();
    var goods_name = $("input[name=goods_name]").val();

    $.get("<?= \yii\helpers\Url::to(['searchgoods']) ?>", {cat_id:cat_id, brand_id:brand_id, goods_name:goods_name}, function(html){

        $('#goodsactivity-goods_id').html(html);
    });
}
//回车搜索
$(".search-input").keyup(function(e) {
    if (e.keyCode === 13) {
        searchGoods();
    }
});

<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['js_end'], $this::POS_END); ?>

