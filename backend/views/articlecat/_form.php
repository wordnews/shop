<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="article-cat-form shop-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'form-horizontal',
        ],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-xs-5\">{input}</div>\n{hint}\n{error}",
        ]
    ]); ?>

    <?= $form->field($model, 'cat_name')->textInput(['maxlength' => true])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= Html::decode($form->field($model, 'parent_id')->dropDownList(\yii\helpers\ArrayHelper::map($catList, 'cat_id', 'cat_name'))->label(null, [
        'class' => 'col-sm-2 control-label'
    ])) ?>

    <?= $form->field($model, 'sort_order')->textInput()->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?php if ($model->show_in_nav === null) $model->show_in_nav = 0; ?>
    <?= $form->field($model, 'show_in_nav')->radioList([
        '1' => '是',
        '0' => '否'
    ], [
        'style' => 'margin-top:7px'
    ])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'keywords')->textInput(['maxlength' => true])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'cat_desc')->textarea()->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <div class="form-group">
        <div class="col-xs-2"></div>
        <?= Html::submitButton($model->isNewRecord ? '确 定' : '更 新', ['class' => $model->isNewRecord ? 'btn btn-success word-btn' : 'btn btn-primary word-btn']) ?>
        <?= Html::a('返 回', 'javascript:history.back(-1)', ['class' => 'btn btn-warning']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
