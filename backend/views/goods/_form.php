<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use dosamigos\datetimepicker\DateTimePicker;

?>

<div class="goods-form shop-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'form-horizontal',
            'enctype' => 'multipart/form-data'
        ],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-xs-5\">{input}</div>\n{hint}\n{error}",
        ]
    ]); ?>

    <!-- 头 begin -->
    <ul id="myTab" class="nav nav-tabs" role="tablist" style="margin-bottom: 20px">
        <li role="presentation" class="active">
            <a href="#general" id="general-tab" role="tab" data-toggle="tab" aria-controls="general" aria-expanded="true">通用信息</a>
        </li>
        <li role="presentation" class="">
            <a href="#detail" role="tab" id="detail-tab" data-toggle="tab" aria-controls="detail" aria-expanded="false">详细描述</a>
        </li>
        <li role="presentation" class="">
            <a href="#other" role="tab" id="other-tab" data-toggle="tab" aria-controls="other" aria-expanded="false">其他信息</a>
        </li>
        <li role="presentation" class="">
            <a href="#properties" role="tab" id="properties-tab" data-toggle="tab" aria-controls="properties" aria-expanded="false">商品属性</a>
        </li>
        <li role="presentation" class="">
            <a href="#gallery" role="tab" id="gallery-tab" data-toggle="tab" aria-controls="gallery" aria-expanded="false">商品相册</a>
        </li>

    </ul>
    <!-- 头 end -->

    <div id="myTabContent" class="tab-content">

        <!-- 通用信息 begin -->

        <div role="tabpanel" class="tab-pane fade active in" id="general" aria-labelledby="general-tab">

            <?= $form->field($model, 'goods_name')->textInput(['maxlength' => true])->label(null, [
                'class' => 'col-sm-2 control-label'
            ]) ?>

            <?= Html::decode($form->field($model, 'cat_id')->dropDownList(\yii\helpers\ArrayHelper::map($categoryList, 'cat_id', 'cat_name'))->label(null, [
                'class' => 'col-sm-2 control-label'
            ])) ?>

            <?= $form->field($model, 'brand_id')->dropDownList(\yii\helpers\ArrayHelper::map($brandList, 'brand_id', 'brand_name'), ['prompt' => '请选择品牌'])->label(null, [
                'class' => 'col-sm-2 control-label'
            ]) ?>

            <?= $form->field($model, 'shop_price')->textInput(['maxlength' => true])->label(null, [
                'class' => 'col-sm-2 control-label'
            ]) ?>

            <?= $form->field($model, 'market_price')->textInput(['maxlength' => true])->label(null, [
                'class' => 'col-sm-2 control-label'
            ]) ?>

            <?php if ($model->give_integral === null) $model->give_integral = -1 ?>
            <?= $form->field($model, 'give_integral')->textInput()->label(null, [
                'class' => 'col-sm-2 control-label'
            ])->hint('购买该商品时赠送消费积分数,-1表示按商品价格赠送') ?>

            <?php if ($model->rank_integral === null) $model->rank_integral = -1 ?>
            <?= $form->field($model, 'rank_integral')->textInput()->label(null, [
                'class' => 'col-sm-2 control-label'
            ])->hint('购买该商品时赠送等级积分数,-1表示按商品价格赠送') ?>

            <?php if ($model->integral === null) $model->integral = 0 ?>
            <?= $form->field($model, 'integral')->textInput()->label(null, [
                'class' => 'col-sm-2 control-label'
            ])->hint('(此处需填写金额)购买该商品时最多可以使用积分的金额') ?>

            <?= $form->field($model, 'is_promote', [
                'template' => "{label}\n<div class=\"col-xs-2\">{input}</div>\n{hint}\n{error}",
            ])->checkbox([
                'style' => 'margin-top:11px'
            ])->label(null, [
                'class' => 'col-sm-2 control-label'
            ])->hint('选择促销，下面的促销信息才有效') ?>

            <?php if ($model->promote_price === null) $model->promote_price = 0 ?>
            <?= $form->field($model, 'promote_price')->textInput(['maxlength' => true])->label(null, [
                'class' => 'col-sm-2 control-label'
            ]) ?>

            <?php
            if ($model->promote_start_date > 0) {
                $model->promote_start_date = date('Y-m-d', $model->promote_start_date);
            } else {
                $model->promote_start_date = '';
            }
            ?>
            <?= $form->field($model, 'promote_start_date')->widget(DateTimePicker::className(), [
                'language' => 'zh-CN',
                'size' => 'ms',
                'template' => '{input}',
                'pickButtonIcon' => 'glyphicon glyphicon-time',
                'clientOptions' => [
                    'startView' => 2,
                    'minView' => 2,
                    'maxView' => 5,
                    'autoclose' => true,
                    'linkFormat' => 'yyyy-mm-dd',
                    'format' => 'yyyy-mm-dd',
                    'todayBtn' => false
                ]
            ])->label(null, [
                'class' => 'col-sm-2 control-label'
            ]) ?>

            <?php
            if ($model->promote_end_date > 0) {
                $model->promote_end_date = date('Y-m-d', $model->promote_end_date);
            } else {
                $model->promote_end_date = '';
            }
            ?>
            <?= $form->field($model, 'promote_end_date')->widget(DateTimePicker::className(), [
                'language' => 'zh-CN',
                'size' => 'ms',
                'template' => '{input}',
                'pickButtonIcon' => 'glyphicon glyphicon-time',
                'clientOptions' => [
                    'startView' => 2,
                    'minView' => 2,
                    'maxView' => 5,
                    'autoclose' => true,
                    'linkFormat' => 'yyyy-mm-dd',
                    'format' => 'yyyy-mm-dd',
                    'todayBtn' => false
                ]
            ])->label(null, [
                'class' => 'col-sm-2 control-label'
            ]) ?>

            <?= $form->field($model, 'goods_img')->fileInput([
                'style' => 'margin-top:7px'
            ])->label(null, [
                'class' => 'col-sm-2 control-label'
            ]) ?>
            <?php if($model->goods_img): ?>
                <div class="col-xs-offset-2 show_goods_image" style="margin-bottom: 5px">
                    <?= Html::activeHiddenInput($model, 'goods_img') ?>
                    <span class="word-btn"></span>
                    <?= Html::img('@web/' . $model->goods_img, ['width' => 50, 'height' => 50]) ?> <a href="javascript:;" style="color: red" title="删除" onclick="delImage(<?= $model->goods_id ?>)">[-]</a>
                </div>
            <?php endif ?>

        </div>

        <!-- 通用信息 end -->

        <!-- 详细描述 begin -->

        <div role="tabpanel" class="tab-pane fade" id="detail" aria-labelledby="detail-tab">

            <?= $form->field($model, 'goods_desc', ['template' => "<div class=\"col-xs-12\">{input}</div>",])->widget(
                \cliff363825\kindeditor\KindEditorWidget::className(),[
                'clientOptions' => [
                    'uploadJson' => Url::to(['upload/uploadeditor']),
                    'width' => '100%',
                    'height' => '350px',
                    'themeType' => 'default', // optional: default, simple, qq
                    'langType' => 'zh_CN', // optional: ar, en, ko, zh_CN, zh_TW
                ],
            ])->label(null, [
                'class' => 'col-sm-12 control-label'
            ]) ?>

        </div>

        <!-- 详细描述 end -->

        <!-- 其他信息 begin -->

        <div role="tabpanel" class="tab-pane fade" id="other" aria-labelledby="other-tab">

            <?/*= $form->field($model, 'goods_weight')->textInput(['maxlength' => true])->label(null, [
                'class' => 'col-sm-2 control-label'
            ]) */?>

            <div class="form-group field-goods-goods_weight">
                <label class="col-sm-2 control-label" for="goods-goods_weight">商品重量</label>
                <div class="col-xs-4">
                    <input type="text" id="goods-goods_weight" class="form-control" name="Goods[goods_weight]" style="width: 70%; display: inline">
                    <select name="weight_unit" class="form-control" style="width: 25%; display: inline">
                        <option value="1">千克</option>
                        <option value="0.001">克</option>
                    </select>
                </div>

                <div class="help-block"></div>
            </div>

            <?php if ($model->goods_number === null) $model->goods_number = 1 ?>
            <?= $form->field($model, 'goods_number')->textInput()->label(null, [
                'class' => 'col-sm-2 control-label'
            ]) ?>

            <?php if ($model->warn_number === null) $model->warn_number = 1 ?>
            <?= $form->field($model, 'warn_number')->textInput()->label(null, [
                'class' => 'col-sm-2 control-label'
            ]) ?>

            <div class="form-group field-goods">
                <label class="col-sm-2 control-label" for="goods-goods">加入推荐</label>
                <div class="col-xs-5">


                    <?= Html::activeCheckbox($model, 'is_best', [
                        'style' => 'margin-top: 12px'
                    ]) ?>

                    <?= Html::activeCheckbox($model, 'is_new', [
                        'style' => 'margin-top: 12px'
                    ]) ?>

                    <?= Html::activeCheckbox($model, 'is_hot', [
                        'style' => 'margin-top: 12px'
                    ]) ?>

                </div>

            </div>

            <?php if ($model->is_on_sale === null) $model->is_on_sale = 1 ?>
            <div class="form-group field-goods">
                <label class="col-sm-2 control-label" for="goods-goods">上架</label>
                <div class="col-xs-5">

                    <?= Html::activeCheckbox($model, 'is_on_sale', [
                        'style' => 'margin-top: 12px'
                    ]) ?>

                </div>

            </div>

            <?php if ($model->is_alone_sale === null) $model->is_alone_sale = 1 ?>
            <div class="form-group field-goods">
                <label class="col-sm-2 control-label" for="goods-goods">能作为普通商品销售</label>
                <div class="col-xs-5">

                    <?= Html::activeCheckbox($model, 'is_alone_sale', [
                        'style' => 'margin-top: 12px'
                    ]) ?>

                </div>

            </div>

            <div class="form-group field-goods">
                <label class="col-sm-2 control-label" for="goods-goods">是否为免运费商品</label>
                <div class="col-xs-5">

                    <?= Html::activeCheckbox($model, 'is_shipping', [
                        'style' => 'margin-top: 12px'
                    ]) ?>

                </div>

            </div>

            <?= $form->field($model, 'keywords')->textInput(['maxlength' => true])->label(null, [
                'class' => 'col-sm-2 control-label'
            ])->hint('用空格分隔') ?>

            <?= $form->field($model, 'goods_brief')->textarea()->label(null, [
                'class' => 'col-sm-2 control-label'
            ]) ?>

            <?= $form->field($model, 'seller_note')->textarea()->label(null, [
                'class' => 'col-sm-2 control-label'
            ])->hint('仅供商家自己看的信息') ?>

        </div>

        <!-- 其他信息 end -->

        <!-- 商品属性 begin -->

        <div role="tabpanel" class="tab-pane fade" id="properties" aria-labelledby="properties-tab">

            <?= $form->field($model, 'goods_type')->dropDownList($goodsTypeList)->label(null, [
                'class' => 'col-sm-2 control-label'
            ])->hint('请选择商品的所属类型，进而完善此商品的属性') ?>

            <!-- 属性表单列表 begin -->
            <div class="goods_type_list">

            </div>
            <!-- 属性表单列表 end -->

        </div>

        <!-- 商品属性 end -->

        <!-- 商品相册 begin -->

        <div role="tabpanel" class="tab-pane fade" id="gallery" aria-labelledby="gallery-tab">

            <div class="row">
            <?php if ($goodsGalleryList) { ?>

                <?php foreach ($goodsGalleryList as $val) { ?>

                <div class="col-sm-2 show_goods_gallery_<?= $val['img_id'] ?>" style="text-align: center">
                    <?= Html::hiddenInput('show_goods_gallery[]', $val['img_url']) ?>
                    <span class="word-btn"></span>
                    <?= Html::img('@web/' . $val['thumb_url'], ['width' => '100%', 'height' => '100%']) ?> <a href="javascript:;" style="color: red;" title="删除" onclick="delGoodsGallery(<?= $val['img_id'] ?>)">[-]</a>
                </div>

            <?php }} ?>
            </div>

            <?= $form->field($GoodsGallery, 'img_url[]', [
                'template' => "{label}\n<div class=\"col-xs-2\">{input}</div>\n{hint}\n{error}",
            ])->fileInput([
                'multiple' => true,
                'accept' => 'image/*',
                'style' => 'margin-top: 8px'
            ])->label(null, [
                'class' => 'col-sm-2 control-label'
            ])->hint('（ 多张图片请按住ctrl键，最多上传6张 ）') ?>

        </div>

        <!-- 商品相册 end -->

    </div>


    <div class="form-group">
        <div class="col-xs-2"></div>
        <?= Html::submitButton($model->isNewRecord ? '确 定' : '更 新', ['class' => $model->isNewRecord ? 'btn btn-success word-btn' : 'btn btn-primary word-btn']) ?>
        <?= Html::a('返 回', 'javascript:history.back(-1)', ['class' => 'btn btn-warning']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php $this->beginBlock('js_end') ?>

/* 商品类型属性表单 begin */
var goods_id = <?= $model->goods_id ? $model->goods_id : 0 ?>;

getGoodsType($('#goods-goods_type').val(), goods_id);

$('#goods-goods_type').change(function(){
    getGoodsType($(this).val(), goods_id);
});

function getGoodsType(goods_type, goods_id)
{
    $.get("<?= Url::to(['getattribute']) ?>", {cat_id: goods_type, goods_id: goods_id}, function(re){

        $('.goods_type_list').html(re);
    });
}
/* 商品类型属性表单 end */

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

/* 删除商品图片 */
function delImage(goods_id) {
    if (confirm('确定要删除这张图片吗？')) {
        $.get("<?= Url::to(['delimage']) ?>", {goods_id:goods_id}, function (re) {
            if (re == 1) {
                $('.show_goods_image').remove();
            }else {
                alert('删除失败了o(╯□╰)o');
            }
        });
    }
}

/* 删除商品相册图片 */
function delGoodsGallery(img_id) {
    if (confirm('确定要删除这张图片吗？')) {
        $.get("<?= Url::to(['delgallery']) ?>", {img_id:img_id}, function (re) {
            if (re == 1) {
                $('.show_goods_gallery_' + img_id).remove();
            }else {
                alert('删除失败了o(╯□╰)o');
            }
        });
    }
}

<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['js_end'], $this::POS_END); ?>

