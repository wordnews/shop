<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="attribute-form shop-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'form-horizontal',
        ],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-xs-5\">{input}</div>\n{hint}\n{error}",
        ]
    ]); ?>

    <?= $form->field($model, 'attr_name')->textInput(['maxlength' => true])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'cat_id')->dropDownList($dropList)->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'attr_group')->dropDownList([
        '0' => '普通',
        '1' => '高级'
    ])->label(null, [
        'class' => 'col-sm-2 control-label'
    ])->hint('类型没有分组，则不管') ?>

    <?php if ($model->sort_order === null) $model->sort_order = 50 ?>
    <?= $form->field($model, 'sort_order')->textInput()->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?php if ($model->attr_index === null) $model->attr_index = 0 ?>
    <?= $form->field($model, 'attr_index')->radioList([
        '0' => '不需要',
        '1' => '关键字检索',
        '2' => '范围检索 '
    ], [
        'style' => 'margin-top:7px'
    ])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?php if ($model->is_linked === null) $model->is_linked = 0 ?>
    <?= $form->field($model, 'is_linked')->radioList([
        '0' => '否',
        '1' => '是'
    ], [
        'style' => 'margin-top:7px'
    ])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?php if ($model->attr_type === null) $model->attr_type = 0 ?>
    <?= $form->field($model, 'attr_type', [
        'template' => "{label}\n<div class=\"col-xs-5\">{input}</div><br/>{hint}\n{error}",
    ])->radioList([
        '0' => '唯一属性',
        '1' => '单选属性',
        '2' => '复选属性 '
    ], [
        'style' => 'margin-top:7px'
    ])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?php if ($model->attr_input_type === null) $model->attr_input_type = 0 ?>
    <?= $form->field($model, 'attr_input_type')->radioList([
        '0' => '手工录入',
        '1' => '从下面的列表中选择（一行代表一个可选值）',
        '2' => '多行文本框'
    ])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'attr_values')->textarea(['rows' => 6])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <div class="form-group">
        <div class="col-xs-2"></div>
        <?= Html::submitButton($model->isNewRecord ? '确 定' : '更 新', ['class' => $model->isNewRecord ? 'btn btn-success word-btn' : 'btn btn-primary word-btn']) ?>
        <?= Html::a('返 回', 'javascript:history.back(-1)', ['class' => 'btn btn-warning']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php $this->beginBlock('js_end') ?>

// 属性分组 begin
attrgroup();

$('#attribute-cat_id').change(function(){
    attrgroup();
});

function attrgroup(){
    var cat_id = $('#attribute-cat_id').val(); // 商品类型id

    $.get("<?= \yii\helpers\Url::to(['attrgroup']) ?>", {cat_id:cat_id, attr_group_id:<?= $model->attr_group ?>}, function (re) {
        $('#attribute-attr_group').html(re);
    });
}
// 属性分组 end

<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['js_end'], $this::POS_END); ?>
