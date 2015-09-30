<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="role-form shop-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'form-horizontal',
        ],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-xs-5\">{input}</div>\n{hint}\n{error}",
        ]
    ]); ?>

    <?= $form->field($model, 'role_name')->textInput(['maxlength' => true])->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <?= $form->field($model, 'role_descript')->textarea()->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th colspan="2">显示的菜单</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($treeMenuList as $key => $menu): ?>
            <tr>
                <td width="20%">
                    <input type="checkbox" name="menu_list[]" value="<?= $menu['menu_id'] ?>" <?= $model->isChecked($model->show_menu, $menu['menu_id']) ? 'checked' : '' ?> >
                    <?= $menu['title'] ?>
                </td>
                <td width="80%">
                    <?php foreach ($menu['_child'] as $k => $item): ?>
                        <div class="col-xs-2" style="padding-top: 2px; padding-bottom: 2px">
                        <input type="checkbox" name="menu_list[]" value="<?= $item['menu_id'] ?>" <?= $model->isChecked($model->show_menu, $item['menu_id']) ? 'checked' : '' ?> >
                        <?= $item['title'] ?>
                        </div>
                    <?php endforeach; ?>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th colspan="2">角色权限控制</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($treeRoleList as $role): ?>
            <tr>
                <td width="20%">
                    <input type="checkbox" >
                    <?= $role['action_title'] ?>
                </td>
                <td width="80%">
                    <?php foreach ($role['_child'] as $item): ?>
                        <div class="col-xs-2" style="padding-top: 2px; padding-bottom: 2px">
                        <input type="checkbox" name="actions_list[]" value="<?= $item['action_code'] ?>" <?= $model->isChecked($model->action_list, $item['action_code']) ? 'checked' : '' ?> >
                        <?= $item['action_title'] ?>
                        </div>
                    <?php endforeach; ?>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>



    <div class="form-group">
        <div class="col-xs-2"></div>
        <?= Html::submitButton($model->isNewRecord ? '确 定' : '更 新', ['class' => $model->isNewRecord ? 'btn btn-success word-btn' : 'btn btn-primary word-btn']) ?>
        <?= Html::a('返 回', 'javascript:history.back(-1)', ['class' => 'btn btn-warning']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
