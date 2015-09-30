<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="nav-form shop-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'form-horizontal',
        ],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-xs-5\">{input}</div>\n{hint}\n{error}",
        ]
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?php if ($model->vieworder === null) $model->vieworder = 50; ?>
    <?= $form->field($model, 'vieworder')->textInput()->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?php if ($model->ifshow === null) $model->ifshow = 1; ?>
    <?= $form->field($model, 'ifshow')->radioList([
        '1' => '是',
        '0' => '否'
    ], [
        'style' => 'margin-top:7px'
    ])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?php if ($model->opennew === null) $model->opennew = 0; ?>
    <?= $form->field($model, 'opennew')->radioList([
        '1' => '是',
        '0' => '否'
    ], [
        'style' => 'margin-top:7px'
    ])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?php if ($model->type === null) $model->type = 'middle'; ?>
    <?= $form->field($model, 'type')->radioList([
        'top' => '顶部',
        'middle' => '中间',
        'bottom' => '底部'
    ], [
        'style' => 'margin-top:7px'
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
