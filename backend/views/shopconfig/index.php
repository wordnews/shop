<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = $this->params['meta_title'] . $this->exTitle;

$this->params['breadcrumbs'][] = $this->params['meta_title'];
?>
<div class="shop-config-create">

    <div class="main_title_wrapper clear">

        <h3><?= Html::encode($this->params['meta_title']) ?></h3>

    </div>


    <div class="shop-config-form shop-form">

        <?php $form = ActiveForm::begin([
            'options' => [
                'class' => 'form-horizontal',
            ],
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-xs-5\">{input}</div>\n{hint}\n{error}",
            ]
        ]); ?>

        <!-- 头 begin -->
        <ul id="myTab" class="nav nav-tabs" role="tablist" style="margin-bottom: 20px">
            <li role="presentation" class="active">
                <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">网店信息</a>
            </li>
            <li role="presentation" class="">
                <a href="#content" role="tab" id="content-tab" data-toggle="tab" aria-controls="content" aria-expanded="false">基本设置</a>
            </li>

        </ul>
        <!-- 头 end -->

        <!-- 内容 begin -->

        <div id="myTabContent" class="tab-content">
            <div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab">

            <?= $form->field($model, 'shop_name')->textInput()->label(null, [
                'class' => 'col-sm-2 control-label'
            ]) ?>

            <?= $form->field($model, 'shop_title')->textInput()->label(null, [
                'class' => 'col-sm-2 control-label'
            ])->hint('商店的标题将显示在浏览器的标题栏') ?>

            <?= $form->field($model, 'shop_keywords')->textInput()->label(null, [
                'class' => 'col-sm-2 control-label'
            ]) ?>

            <?= $form->field($model, 'shop_desc')->textarea()->label(null, [
                'class' => 'col-sm-2 control-label'
            ]) ?>

            <?= $form->field($model, 'shop_address')->textInput()->label(null, [
                'class' => 'col-sm-2 control-label'
            ]) ?>

            <?= $form->field($model, 'qq')->textInput()->label(null, [
                'class' => 'col-sm-2 control-label'
            ]) ?>

            <?= $form->field($model, 'ww')->textInput()->label(null, [
                'class' => 'col-sm-2 control-label'
            ]) ?>

            <?= $form->field($model, 'service_email')->textInput()->label(null, [
                'class' => 'col-sm-2 control-label'
            ]) ?>

            <?= $form->field($model, 'service_phone')->textInput()->label(null, [
                'class' => 'col-sm-2 control-label'
            ]) ?>

            <?php if ($model->shop_closed === null) $model->shop_closed = 0 ?>
            <?= $form->field($model, 'shop_closed')->radioList([
                '0' => '否',
                '1' => '是'
            ], [
                'style' => 'margin-top:7px'
            ])->label(null, [
                'class' => 'col-sm-2 control-label'
            ]) ?>

            <?= $form->field($model, 'close_comment')->textarea()->label(null, [
                'class' => 'col-sm-2 control-label'
            ]) ?>

            <?= $form->field($model, 'user_notice')->textarea()->label(null, [
                'class' => 'col-sm-2 control-label'
            ])->hint('该信息将在用户中心欢迎页面显示') ?>

            <?= $form->field($model, 'shop_notice')->textarea()->label(null, [
                'class' => 'col-sm-2 control-label'
            ])->hint('以上内容将显示在首页商店公告中,注意控制公告内容长度不要超过公告显示区域大小。') ?>

            <?php if ($model->shop_reg_closed === null) $model->shop_reg_closed = 0 ?>
            <?= $form->field($model, 'shop_reg_closed')->radioList([
                '0' => '否',
                '1' => '是'
            ], [
                'style' => 'margin-top:7px'
            ])->label(null, [
                'class' => 'col-sm-2 control-label'
            ]) ?>


            </div>

            <div role="tabpanel" class="tab-pane fade" id="content" aria-labelledby="content-tab">

                <?= $form->field($model, 'stats_code')->textarea([
                    'rows' => 3
                ])->label(null, [
                    'class' => 'col-sm-2 control-label'
                ]) ?>

                <?= $form->field($model, 'register_points')->textInput()->label(null, [
                    'class' => 'col-sm-2 control-label'
                ]) ?>

                <?php if ($model->comment_check === null) $model->comment_check = 0 ?>
                <?= $form->field($model, 'comment_check')->radioList([
                    '0' => '否',
                    '1' => '是'
                ], [
                    'style' => 'margin-top:7px'
                ])->label(null, [
                    'class' => 'col-sm-2 control-label'
                ]) ?>

                <?php if ($model->enable_order_check === null) $model->enable_order_check = 1 ?>
                <?= $form->field($model, 'enable_order_check')->radioList([
                    '0' => '否',
                    '1' => '是'
                ], [
                    'style' => 'margin-top:7px'
                ])->label(null, [
                    'class' => 'col-sm-2 control-label'
                ]) ?>

                <?php if ($model->visit_stats === null) $model->visit_stats = 1 ?>
                <?= $form->field($model, 'visit_stats')->radioList([
                    '1' => '开启',
                    '0' => '关闭'
                ], [
                    'style' => 'margin-top:7px'
                ])->label(null, [
                    'class' => 'col-sm-2 control-label'
                ]) ?>

                <?php if ($model->message_board === null) $model->message_board = 1 ?>
                <?= $form->field($model, 'message_board')->radioList([
                    '1' => '开启',
                    '0' => '关闭'
                ], [
                    'style' => 'margin-top:7px'
                ])->label(null, [
                    'class' => 'col-sm-2 control-label'
                ]) ?>

                <?php if ($model->send_verify_email === null) $model->send_verify_email = 1 ?>
                <?= $form->field($model, 'send_verify_email', [
                    'template' => "{label}\n<div class=\"col-xs-2\">{input}</div>\n{hint}\n{error}",
                ])->radioList([
                    '1' => '开启',
                    '0' => '关闭'
                ], [
                    'style' => 'margin-top:7px'
                ])->label(null, [
                    'class' => 'col-sm-2 control-label'
                ])->hint('“是否开启会员邮件验证”设为开启时才可使用此功能') ?>

                <?php if ($model->message_check === null) $model->message_check = 0 ?>
                <?= $form->field($model, 'message_check')->radioList([
                    '1' => '是',
                    '0' => '否'
                ], [
                    'style' => 'margin-top:7px'
                ])->label(null, [
                    'class' => 'col-sm-2 control-label'
                ]) ?>

            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-2"></div>
            <?= Html::submitButton('更 新', ['class' => 'btn btn-primary word-btn']) ?>
        </div>

        <!-- 内容 end -->
        <?php ActiveForm::end(); ?>

    </div>

</div>
