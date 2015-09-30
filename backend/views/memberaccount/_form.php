<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="member-account-form shop-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'form-horizontal',
        ],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-xs-5\">{input}</div>\n{hint}\n{error}",
        ]
    ]); ?>

    <?= $form->field($model, 'user_name')->textInput()->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => true])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'payment')->dropDownList(\yii\helpers\ArrayHelper::map($payment, 'pay_name', 'pay_name'), ['prompt' => '请选择支付方式'])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?php if ($model->process_type === null) $model->process_type = 0 ?>
    <?= $form->field($model, 'process_type')->radioList([
        '0' => '充值',
        '1' => '提现'
    ], ['style' => 'margin-top: 6px'])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'admin_note')->textarea()->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'user_note')->textarea()->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?php if ($model->is_paid === null) $model->is_paid = 0 ?>
    <?= $form->field($model, 'is_paid')->radioList([
        '0' => '未确认',
        '1' => '已完成',
    ], ['style' => 'margin-top: 6px'])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <div class="form-group">
        <div class="col-xs-2"></div>
        <?= Html::submitButton($model->isNewRecord ? '确 定' : '更 新', ['class' => $model->isNewRecord ? 'btn btn-success word-btn' : 'btn btn-primary word-btn']) ?>
        <?= Html::a('返 回', 'javascript:history.back(-1)', ['class' => 'btn btn-warning']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
