<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="friend-link-form shop-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'form-horizontal',
            'enctype' => 'multipart/form-data'
        ],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-xs-5\">{input}</div>\n{hint}\n{error}",
        ]
    ]); ?>

    <?= $form->field($model, 'link_name')->textInput(['maxlength' => true])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'link_url')->textInput(['maxlength' => true])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'link_logo')->fileInput()->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?php if($model->link_logo): ?>
        <?= Html::activeHiddenInput($model, 'link_logo') ?>
        <div class="col-xs-offset-2" style="margin-bottom: 5px">
            <span class="word-btn"></span>
            <?= Html::img('@web/' . $model->link_logo, ['width' => 50, 'height' => 50]) ?>
        </div>
    <?php endif ?>

    <?php if(!$model->show_order) $model->show_order = 50; ?>
    <?= $form->field($model, 'show_order')->textInput()->label(null, [
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
        <?= Html::submitButton($model->isNewRecord ? '确 定' : '更 新', ['class' => $model->isNewRecord ? 'btn btn-success word-btn' : 'btn btn-primary word-btn']) ?>
        <?= Html::a('返 回', 'javascript:history.back(-1)', ['class' => 'btn btn-warning']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
