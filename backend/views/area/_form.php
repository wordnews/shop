<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Region;

$region_type = $_GET['parent_id'] ? $_GET['parent_id'] : 0;

if ($region_type !== 0) {
    $region_type = Region::findOne($region_type)->region_type + 1;
}

?>

<div class="region-form shop-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'form-horizontal',
        ],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-xs-5\">{input}</div>\n{hint}\n{error}",
        ]
    ]); ?>

    <?php if ($model->parent_id === null) $model->parent_id = $_GET['parent_id'] ? $_GET['parent_id'] : 0 ?>
    <?= $form->field($model, 'parent_id')->hiddenInput()->label(false, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'region_name')->textInput(['maxlength' => true])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?php if ($model->region_type === null) $model->region_type = $region_type ?>
    <?= $form->field($model, 'region_type')->hiddenInput()->label(false, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <div class="form-group">
        <div class="col-xs-2"></div>
        <?= Html::submitButton($model->isNewRecord ? '确 定' : '更 新', ['class' => $model->isNewRecord ? 'btn btn-success word-btn' : 'btn btn-primary word-btn']) ?>
        <?= Html::a('返 回', 'javascript:history.back(-1)', ['class' => 'btn btn-warning']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
