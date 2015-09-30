<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="ad-position-form shop-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'form-horizontal',
        ],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-xs-5\">{input}</div>\n{hint}\n{error}",
        ]
    ]); ?>

    <?= $form->field($model, 'position_name')->textInput(['maxlength' => true])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?php if ($model->ad_width === null) $model->ad_width = 100; ?>
    <?= $form->field($model, 'ad_width')->textInput([
        'placeholder' => '像素'
    ])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?php if ($model->ad_height === null) $model->ad_height = 100; ?>
    <?= $form->field($model, 'ad_height')->textInput([
        'placeholder' => '像素'
    ])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'position_desc')->textInput(['maxlength' => true])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'position_style')->textarea(['rows' => 3])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <div class="form-group">
        <div class="col-xs-2"></div>
        <?= Html::submitButton($model->isNewRecord ? '确 定' : '更 新', ['class' => $model->isNewRecord ? 'btn btn-success word-btn' : 'btn btn-primary word-btn']) ?>
        <?= Html::a('返 回', 'javascript:history.back(-1)', ['class' => 'btn btn-warning']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
