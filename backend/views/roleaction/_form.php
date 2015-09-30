<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="role-action-form shop-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'form-horizontal',
        ],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-xs-5\">{input}</div>\n{hint}\n{error}",
        ]
    ]); ?>

    <?= $form->field($model, 'action_title')->textInput(['maxlength' => true])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'action_code')->textInput(['maxlength' => true])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'parent_id')->dropDownList(\yii\helpers\ArrayHelper::map($actionTop, 'action_id', 'action_title'))->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <div class="form-group">
        <div class="col-xs-2"></div>
        <?= Html::submitButton($model->isNewRecord ? '确 定' : '更 新', ['class' => $model->isNewRecord ? 'btn btn-success word-btn' : 'btn btn-primary word-btn']) ?>
        <?= Html::a('返 回', 'javascript:history.back(-1)', ['class' => 'btn btn-warning']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
