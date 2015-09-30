<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="brand-form shop-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'form-horizontal',
            'enctype' => 'multipart/form-data'
        ],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-xs-5\">{input}</div>\n{hint}\n{error}",
        ]
    ]); ?>

    <?= $form->field($model, 'brand_name')->textInput(['maxlength' => true])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'site_url')->textInput(['maxlength' => true])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'brand_logo')->fileInput()->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?php if($model->brand_logo): ?>
        <?= Html::activeHiddenInput($model, 'brand_logo') ?>
        <div class="col-xs-offset-2" style="margin-bottom: 5px">
            <span class="word-btn"></span>
            <?= Html::img('@web/' . $model->brand_logo, ['width' => 50, 'height' => 50]) ?>
        </div>
    <?php endif ?>

    <?= $form->field($model, 'brand_desc')->textarea(['rows' => 3])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?php if ($model->sort === null) $model->sort = 50; ?>
    <?= $form->field($model, 'sort')->textInput()->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?php if ($model->is_hot === null) $model->is_hot = 1; ?>
    <?= $form->field($model, 'is_hot')->radioList([
        '1' => '是',
        '0' => '否'
    ], ['style' => 'margin-top:7px'])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?php if ($model->status === null) $model->status = 1; ?>
    <?= $form->field($model, 'status')->radioList([
        '1' => '是',
        '0' => '否'
    ], ['style' => 'margin-top:7px'])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <div class="form-group">
        <div class="col-xs-2"></div>
        <?= Html::submitButton($model->isNewRecord ? '确 定' : '更 新', ['class' => $model->isNewRecord ? 'btn btn-success word-btn' : 'btn btn-primary word-btn']) ?>
        <?= Html::a('返 回', 'javascript:history.back(-1)', ['class' => 'btn btn-warning']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
