<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="member-rank-form shop-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'form-horizontal',
        ],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-xs-5\">{input}</div>\n{hint}\n{error}",
        ]
    ]); ?>

    <?= $form->field($model, 'rank_name')->textInput(['maxlength' => true])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'min_points')->textInput()->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'max_points')->textInput()->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <div class="form-group field-memberrank-show_price">
        <label class="col-sm-2 control-label" for="memberrank-show_price"></label>
        <div class="col-xs-5"><input type="hidden" name="MemberRank[show_price]" value="0"><label>
                <?php if ($model->show_price === null) $model->show_price = 1 ?>
                <?= Html::activeCheckbox($model, 'show_price') ?>
            </label></div>
    </div>

    <?= $form->field($model, 'special_rank', ['template' => "{label}\n<div class=\"col-xs-2\">{input}</div>\n{hint}\n{error}",])->checkbox(['style' => 'margin-top: 10px'])->label(null, [
        'class' => 'col-sm-2 control-label'
    ])->hint('特殊会员组的会员不会随着积分的变化而变化。') ?>

    <?php if ($model->discount === null) $model->discount = 100 ?>
    <?= $form->field($model, 'discount', ['template' => "{label}\n<div class=\"col-xs-2\">{input}</div>\n{hint}\n{error}",])->textInput()->label(null, [
        'class' => 'col-sm-2 control-label'
    ])->hint('请填写为0-100的整数,如填入80，表示初始折扣率为8折') ?>

    <div class="form-group">
        <div class="col-xs-2"></div>
        <?= Html::submitButton($model->isNewRecord ? '确 定' : '更 新', ['class' => $model->isNewRecord ? 'btn btn-success word-btn' : 'btn btn-primary word-btn']) ?>
        <?= Html::a('返 回', 'javascript:history.back(-1)', ['class' => 'btn btn-warning']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
