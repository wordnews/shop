<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="category-form shop-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'form-horizontal',
        ],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-xs-5\">{input}</div>\n{hint}\n{error}",
        ]
    ]); ?>

    <?= $form->field($model, 'cat_name')->textInput(['maxlength' => true])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= Html::decode($form->field($model, 'parent_id')->dropDownList(\yii\helpers\ArrayHelper::map($catList, 'cat_id', 'cat_name'))->label(null, [
        'class' => 'col-sm-2 control-label'
    ])) ?>

    <?= $form->field($model, 'measure_unit')->textInput(['maxlength' => true])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'sort_order')->textInput()->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?php if ($model->is_show === null) $model->is_show = 1; ?>
    <?= $form->field($model, 'is_show')->radioList([
        '1' => '是',
        '0' => '否'
    ], [
        'style' => 'margin-top:7px'
    ])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?php if ($model->show_in_nav === null) $model->show_in_nav = 0; ?>
    <?= $form->field($model, 'show_in_nav')->radioList([
        '1' => '是',
        '0' => '否'
    ], [
        'style' => 'margin-top:7px'
    ])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'recommend_type')->checkboxList([
        '1' => '精品',
        '2' => '最新',
        '3' => '热门'
    ], [
        'style' => 'margin-top:7px'
    ])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'filter_attr')->textInput(['maxlength' => true])->label(null, [
        'class' => 'col-sm-2 control-label'
    ])->hint('（商品属性id，多个以英文逗号分隔）筛选属性可在前分类页面筛选商品') ?>

    <?php if ($model->grade === null) $model->grade = 0; ?>
    <?= $form->field($model, 'grade', [
        'template' => "{label}\n<div class=\"col-xs-2\">{input}</div>\n{hint}\n{error}",
    ])->textInput()->label(null, [
        'class' => 'col-sm-2 control-label'
    ])->hint('最低价与最高价之间的划分的等级个数，填0表示不做分级，最多不能超过10个。') ?>

    <?= $form->field($model, 'style')->textInput(['maxlength' => true])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'keywords')->textInput(['maxlength' => true])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'cat_desc')->textarea([
        'rows' => 3
    ])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <div class="form-group">
        <div class="col-xs-2"></div>
        <?= Html::submitButton($model->isNewRecord ? '确 定' : '更 新', ['class' => $model->isNewRecord ? 'btn btn-success word-btn' : 'btn btn-primary word-btn']) ?>
        <?= Html::a('返 回', 'javascript:history.back(-1)', ['class' => 'btn btn-warning']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
