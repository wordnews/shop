<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use dosamigos\datetimepicker\DateTimePicker;

?>

<div class="ad-form shop-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'form-horizontal',
            'enctype' => 'multipart/form-data'
        ],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-xs-5\">{input}</div>\n{hint}\n{error}",
        ]
    ]); ?>

    <?= $form->field($model, 'ad_name')->textInput(['maxlength' => true])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'media_type')->dropDownList($mediaList)->label(null, [
        'class' => 'col-sm-2 control-label',
    ]) ?>

    <span class="media_type_html">

    </span>

    <?php if($model->media_type == 0 && $model->ad_code): ?>
        <?/*= Html::activeHiddenInput($model, 'ad_code') */?>
        <div class="col-xs-offset-2" style="margin-bottom: 5px">
            <span class="word-btn"></span>
            <?= Html::img('@web/' . $model->ad_code, ['width' => 50, 'height' => 50]) ?>
        </div>
    <?php endif ?>

    <?= $form->field($model, 'position_id')->dropDownList($position)->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'ad_link')->textInput(['maxlength' => true])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?php if ($model->start_time > 0) $model->start_time = date('Y-m-d', $model->start_time); if ($model->start_time == 0) $model->start_time = '' ?>
    <?= $form->field($model, 'start_time')->widget(DateTimePicker::className(), [
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

    <?php if ($model->end_time > 0) $model->end_time = date('Y-m-d', $model->end_time); if ($model->end_time == 0) $model->end_time = '' ?>
    <?= $form->field($model, 'end_time')->widget(DateTimePicker::className(), [
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

    <?= $form->field($model, 'link_man')->textInput(['maxlength' => true])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'link_email')->textInput(['maxlength' => true])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'link_phone')->textInput(['maxlength' => true])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?php if ($model->enabled === null) $model->enabled = 1; ?>
    <?= $form->field($model, 'enabled')->radioList([
        '1' => '开启',
        '0' => '关闭'
    ], [
        'style' => 'margin-top:7px'
    ])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <div class="form-group">
        <div class="col-xs-2"></div>
        <?= Html::submitButton($model->isNewRecord ? '确 定' : '更 新', ['class' => $model->isNewRecord ? 'btn btn-success word-btn' : 'btn btn-primary word-btn']) ?>
        <?= Html::a('返 回', 'javascript:history.back(-1)', ['class' => 'btn btn-warning']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php $this->beginBlock('js_end') ?>

    adHtml();
    $('#ad-media_type').change(function(){
        adHtml();
    });

    function adHtml()
    {
        var media_type = $('#ad-media_type').val();
        $.get("<?= Url::to(['adhtml']) ?>", {media_type:media_type}, function(data){
            $('.media_type_html').html(data);
        });
    }

<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['js_end'], $this::POS_END); ?>
