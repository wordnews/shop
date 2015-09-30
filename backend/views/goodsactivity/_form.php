<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="goods-activity-form shop-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'form-horizontal',
        ],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-xs-5\">{input}</div>\n{hint}\n{error}",
        ]
    ]); ?>

    <?= $form->field($model, 'act_name')->textInput(['maxlength' => true])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'act_desc')->textarea(['rows' => 6])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'act_type')->textInput()->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'goods_id')->textInput()->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'product_id')->textInput()->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'goods_name')->textInput(['maxlength' => true])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'start_time')->textInput()->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'end_time')->textInput()->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'is_finished')->textInput()->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'ext_info')->textarea(['rows' => 6])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <div class="form-group">
        <div class="col-xs-2"></div>
        <?= Html::submitButton($model->isNewRecord ? '确 定' : '更 新', ['class' => $model->isNewRecord ? 'btn btn-success word-btn' : 'btn btn-primary word-btn']) ?>
        <?= Html::a('返 回', 'javascript:history.back(-1)', ['class' => 'btn btn-warning']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
