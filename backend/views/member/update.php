<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datetimepicker\DateTimePicker;

$this->title = $this->params['meta_title'] . $this->exTitle;

$this->params['breadcrumbs'][] = ['label' => '会员列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->params['meta_title'];
?>
<div class="member-update">

    <div class="main_title_wrapper clear">

        <h3><?= Html::encode($this->params['meta_title']) ?></h3>
        <p class="action">
            <?=Html::a('会员列表', ['index'], ['class' => 'btn btn-success']) ?>
        </p>

    </div>

    <hr>

    <div class="member-form shop-form">

        <?php $form = ActiveForm::begin([
            'options' => [
                'class' => 'form-horizontal',
            ],
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-xs-5\">{input}</div>\n{hint}\n{error}",
            ]
        ]); ?>

        <?= $form->field($model, 'user_name')->textInput([
            'maxlength' => true,
            'disabled' => 'disabled'
        ])->label(null, [
            'class' => 'col-sm-2 control-label'
        ]) ?>

        <?= $form->field($model, 'user_money', [
            'template' => "{label}\n<div class=\"col-xs-2\">{input}</div>\n{hint}\n{error}",
        ])->textInput([
            'maxlength' => true,
            'disabled' => 'disabled'
        ])->label(null, [
            'class' => 'col-sm-2 control-label'
        ])->hint(Html::a('[ 查看明细 ]', 'javascript:;')) ?>

        <?= $form->field($model, 'frozen_money', [
            'template' => "{label}\n<div class=\"col-xs-2\">{input}</div>\n{hint}\n{error}",
        ])->textInput([
            'maxlength' => true,
            'disabled' => 'disabled'
        ])->label(null, [
            'class' => 'col-sm-2 control-label'
        ])->hint(Html::a('[ 查看明细 ]', 'javascript:;')) ?>

        <?= $form->field($model, 'rank_points', [
            'template' => "{label}\n<div class=\"col-xs-2\">{input}</div>\n{hint}\n{error}",
        ])->textInput([
            'maxlength' => true,
            'disabled' => 'disabled'
        ])->label(null, [
            'class' => 'col-sm-2 control-label'
        ])->hint(Html::a('[ 查看明细 ]', 'javascript:;') . ' 等级积分是一种累计的积分，系统根据该积分来判定用户的会员等级。') ?>

        <?= $form->field($model, 'pay_points', [
            'template' => "{label}\n<div class=\"col-xs-2\">{input}</div>\n{hint}\n{error}",
        ])->textInput([
            'maxlength' => true,
            'disabled' => 'disabled'
        ])->label(null, [
            'class' => 'col-sm-2 control-label'
        ])->hint(Html::a('[ 查看明细 ]', 'javascript:;') . ' 消费积分是一种站内货币，允许用户在购物时支付一定比例的积分。') ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true])->label(null, [
            'class' => 'col-sm-2 control-label'
        ]) ?>

        <?php $model->password = null ?>
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

        <?php if ($model->birthday == '0000-00-00') $model->birthday = null ?>
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

</div>
