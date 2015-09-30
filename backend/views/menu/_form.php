<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="menu-form shop-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'form-horizontal',
        ],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-xs-5\">{input}</div>\n{hint}\n{error}",
        ]
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?php
        if (isset($_GET['pid']) && $_GET['pid'] > 0) {
            $model->pid = $_GET['pid'];
        }
    ?>
    <?= $form->field($model, 'pid')->dropDownList(\yii\helpers\ArrayHelper::map($menuTop, 'menu_id', 'title'), ['prompt' => '顶级分类'])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true])->label(null, [
        'class' => 'col-sm-2 control-label'
    ])->hint('顶级分类不用填') ?>

    <?php if(!$model->sort) $model->sort = 50; ?>
    <?= $form->field($model, 'sort')->textInput()->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'status')->dropDownList([
        '1' => '正常',
        '0' => '禁用'
    ])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <div class="form-group">
        <div class="col-xs-2"></div>
        <?= Html::submitButton($model->isNewRecord ? '创建菜单' : '更新菜单', ['class' => $model->isNewRecord ? 'btn btn-success word-btn' : 'btn btn-primary word-btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
