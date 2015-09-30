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

        <div style="margin: 0 20px">
            <span style="font-weight: bold; font-size: 16px">会员金额信息：</span>
            <hr style="margin-top: 5px; margin-bottom: 5px; border-top: 1px solid #eee8d5">
            <span style="font-weight: bold; font-size: 14px">会员名称：</span>
            <?= Member::findOne($model->user_id)->user_name; ?> &nbsp;&nbsp;
            <span style="font-weight: bold; font-size: 14px">金额：</span>
            <?= $model->amount ?> &nbsp;&nbsp;
            <span style="font-weight: bold; font-size: 14px">操作日期：</span>
            <?= date('Y-m-d H:i', $model->add_time) ?> &nbsp;&nbsp;
            <span style="font-weight: bold; font-size: 14px">类型：</span>
            <?= $model->processTypeStatus[$model->process_type] ?> &nbsp;&nbsp;

            <br><br>
            <span style="font-weight: bold; font-size: 16px">其他信息：</span>
            <hr style="margin-top: 5px; margin-bottom: 5px; border-top: 1px solid #eee8d5">
        </div>

        <?= $form->field($model, 'admin_note')->textarea()->label(null, [
            'class' => 'col-sm-2 control-label'
        ]) ?>

        <?= $form->field($model, 'is_paid')->radioList([
            '0' => '未确认',
            '1' => '已完成',
        ], ['style' => 'margin-top: 6px'])->label(null, [
            'class' => 'col-sm-2 control-label'
        ]) ?>

        <div class="form-group">
            <div class="col-xs-2"></div>
            <?= Html::submitButton($model->isNewRecord ? '确 定' : '确 定', ['class' => $model->isNewRecord ? 'btn btn-success word-btn' : 'btn btn-primary word-btn']) ?>
            <?= Html::a('返 回', 'javascript:history.back(-1)', ['class' => 'btn btn-warning']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
