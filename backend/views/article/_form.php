<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>

<div class="article-form shop-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'form-horizontal',
        ],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-xs-5\">{input}</div>\n{hint}\n{error}",
        ]
    ]); ?>

    <ul id="myTab" class="nav nav-tabs" role="tablist" style="margin-bottom: 20px">
        <li role="presentation" class="active">
            <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">基本信息</a>
        </li>
        <li role="presentation" class="">
            <a href="#content" role="tab" id="content-tab" data-toggle="tab" aria-controls="content" aria-expanded="false">文章内容</a>
        </li>
        <li role="presentation" class="">
            <a href="#goods" role="tab" id="goods-tab" data-toggle="tab" aria-controls="goods" aria-expanded="false">关联商品</a>
        </li>
    </ul>

    <div id="myTabContent" class="tab-content">
        <div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab">

        <?= $form->field($model, 'title')->textInput(['maxlength' => 150])->label(null, [
            'class' => 'col-sm-2 control-label'
        ]) ?>

        <?= Html::decode($form->field($model, 'cat_id')->dropDownList(\yii\helpers\ArrayHelper::map($catList, 'cat_id', 'cat_name'))->label(null, [
            'class' => 'col-sm-2 control-label'
        ])) ?>

        <?php if ($model->article_type === null) $model->article_type = 0; ?>
        <?= $form->field($model, 'article_type')->radioList([
            '0' => '普通',
            '1' => '置顶'
        ], [
            'style' => 'margin-top:7px'
        ])->label(null, [
            'class' => 'col-sm-2 control-label'
        ]) ?>

        <?php if ($model->status === null) $model->status = 1; ?>
        <?= $form->field($model, 'status')->radioList([
            '1' => '是',
            '0' => '否'
        ], [
            'style' => 'margin-top:7px'
        ])->label(null, [
            'class' => 'col-sm-2 control-label'
        ]) ?>


        <?php if ($model->is_hot === null) $model->is_hot = 0; ?>
        <?= $form->field($model, 'is_hot')->radioList([
            '1' => '是',
            '0' => '否'
        ], [
            'style' => 'margin-top:7px'
        ])->label(null, [
            'class' => 'col-sm-2 control-label'
        ]) ?>

        <?= $form->field($model, 'author')->textInput(['maxlength' => 30])->label(null, [
            'class' => 'col-sm-2 control-label'
        ]) ?>

        <?= $form->field($model, 'author_email')->textInput(['maxlength' => 60])->label(null, [
            'class' => 'col-sm-2 control-label'
        ]) ?>

        <?= $form->field($model, 'keywords')->textInput(['maxlength' => 255])->label(null, [
            'class' => 'col-sm-2 control-label'
        ]) ?>

        <?= $form->field($model, 'description')->textarea([
            'rows' => 3
        ])->label(null, [
            'class' => 'col-sm-2 control-label'
        ]) ?>

    </div>

    <div role="tabpanel" class="tab-pane fade" id="content" aria-labelledby="content-tab">

        <?= $form->field($model, 'content', ['template' => "<div class=\"col-xs-12\">{input}</div>",])->widget(
            \cliff363825\kindeditor\KindEditorWidget::className(),[
            'clientOptions' => [
                'uploadJson' => Url::to(['upload/uploadeditor']),
                'width' => '100%',
                'height' => '350px',
                'themeType' => 'default', // optional: default, simple, qq
                'langType' => 'zh_CN', // optional: ar, en, ko, zh_CN, zh_TW
            ],
        ])->label(null, [
            'class' => 'col-sm-12 control-label'
        ]) ?>

    </div>

        <div role="tabpanel" class="tab-pane fade" id="goods" aria-labelledby="goods-tab">



        </div>

    </div>

    <div class="form-group">
        <div class="col-xs-2"></div>
        <?= Html::submitButton($model->isNewRecord ? '确 定' : '更 新', ['class' => $model->isNewRecord ? 'btn btn-success word-btn' : 'btn btn-primary word-btn']) ?>
        <?= Html::a('返 回', 'javascript:history.back(-1)', ['class' => 'btn btn-warning']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
