<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datetimepicker\DateTimePicker;

?>

<div class="member-form shop-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'form-horizontal',
        ],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-xs-5\">{input}</div>\n{hint}\n{error}",
        ]
    ]); ?>

    <?= $form->field($model, 'user_name')->textInput(['maxlength' => true])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'repassword')->passwordInput(['maxlength' => true])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'user_rank')->dropDownList($SpecialRank)->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?php if ($model->sex === null) $model->sex = 0 ?>
    <?= $form->field($model, 'sex')->radioList([
        '0' => ' 保密',
        '1' => '男',
        '2' => '女'
    ], [
        'style' => 'margin-top: 6px'
    ])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'birthday')->widget(DateTimePicker::className(), [
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

    <?php if ($model->credit_line === null) $model->credit_line = 0 ?>
    <?= $form->field($model, 'credit_line')->textInput(['maxlength' => true])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'qq')->textInput(['maxlength' => true])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'mobile_phone')->textInput(['maxlength' => true])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <div class="form-group">
        <div class="col-xs-2"></div>
        <?= Html::submitButton($model->isNewRecord ? '确 定' : '更 新', ['class' => $model->isNewRecord ? 'btn btn-success word-btn' : 'btn btn-primary word-btn']) ?>
        <?= Html::a('返 回', 'javascript:history.back(-1)', ['class' => 'btn btn-warning']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
