<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Member;


$this->title = $this->params['meta_title'] . $this->exTitle;

$this->params['breadcrumbs'][] = ['label' => '充值和提现申请', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->params['meta_title'];
?>
<div class="member-account-update">

    <div class="main_title_wrapper clear">

        <h3><?= Html::encode($this->params['meta_title']) ?></h3>
        <p class="action">
            <?=Html::a('充值和提现申请', ['index'], ['class' => 'btn btn-success']) ?>
        </p>

    </div>

    <hr>

    <div class="member-account-form shop-form">

        <?php $form = ActiveForm::begin([
            'options' => [
                'class' => 'form-horizontal',
            ],
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-xs-5\">{input}</div>\n{hint}\n{error}",
            ]
        ]); ?>

        <?php if ($model->user_id) $model->user_name = Member::findOne($model->user_id)->user_name ?>
        <?= $form->field($model, 'user_name')->textInput(['readonly' => 'readonly'])->label(null, [
            'class' => 'col-sm-2 control-label'
        ]) ?>

        <?= $form->field($model, 'amount')->textInput(['readonly' => 'readonly'])->label(null, [
            'class' => 'col-sm-2 control-label'
        ]) ?>

        <?= $form->field($model, 'payment')->dropDownList(\yii\helpers\ArrayHelper::map($payment, 'pay_name', 'pay_name'), ['prompt' => '请选择支付方式'])->label(null, [
            'class' => 'col-sm-2 control-label'
        ]) ?>

        <?php if ($model->process_type == 1){
            $type1 = false;
            $type2 = true;
        } else {
            $type1 = true;
            $type2 = false;
        } ?>
        <div class="form-group field-memberaccount-process_type required has-success">
            <label class="col-sm-2 control-label" for="memberaccount-process_type">类型</label>
            <div class="col-xs-5">
                <input type="hidden" name="MemberAccount[process_type]" value="">
                <div id="memberaccount-process_type" style="margin-top: 6px">
                    <label>
                        <?= Html::radio('MemberAccount[process_type]', $type1, ['value' => 0, 'disabled' => 'disabled']) ?> 充值
                    </label>
                    <label>
                        <?= Html::radio('MemberAccount[process_type]', $type2, ['value' => 1, 'disabled' => 'disabled']) ?> 提现
                    </label>
                </div>
            </div>
        </div>

        <?= $form->field($model, 'admin_note')->textarea()->label(null, [
            'class' => 'col-sm-2 control-label'
        ]) ?>

        <?= $form->field($model, 'user_note')->textarea()->label(null, [
            'class' => 'col-sm-2 control-label'
        ]) ?>

        <?php if ($model->is_paid == 1) {
            $paid1 = true;
            $paid2 = false;
        } else {
            $paid1 = false;
            $paid2 = true;
        } ?>
        <div class="form-group field-memberaccount-is_paid">
            <label class="col-sm-2 control-label" for="memberaccount-is_paid">到款状态</label>
            <div class="col-xs-5">
                <input type="hidden" name="MemberAccount[is_paid]" value="">
                <div id="memberaccount-is_paid" style="margin-top: 6px">
                    <label>
                        <?= Html::radio('MemberAccount[is_paid]', $paid2, ['value' => 0, 'disabled' => 'disabled']) ?> 未确认
                    </label>
                    <label>
                        <?= Html::radio('MemberAccount[is_paid]', $paid1, ['value' => 0, 'disabled' => 'disabled']) ?> 已完成
                    </label>
                </div>
            </div>
        </div>


        <div class="form-group">
            <div class="col-xs-2"></div>
            <?= Html::submitButton($model->isNewRecord ? '确 定' : '更 新', ['class' => $model->isNewRecord ? 'btn btn-success word-btn' : 'btn btn-primary word-btn']) ?>
            <?= Html::a('返 回', 'javascript:history.back(-1)', ['class' => 'btn btn-warning']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
