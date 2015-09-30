<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = $this->params['meta_title'] . $this->exTitle;

$this->params['breadcrumbs'][] = $this->params['meta_title'];
?>
<div class="role-action-index">

    <div class="main_title_wrapper clear">
        <h3><?= Html::encode($this->params['meta_title']) ?></h3>
        <span style="color: red; font-size: 16px">（非专业人士请不要乱操作这里）</span>
    
        <p class="action">
            <?= Html::a('添加角色节点', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    </div>

    <?php Pjax::begin() ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            [
                'attribute' => 'action_title',
                'content' => function($model){
                    return Html::a($model->action_title, ['index', 'pid' => $model->action_id]);
                }
            ],
            [
                'attribute' => 'parent_id',
                'label' => '上级节点',
                'value' => function($model){
                    return $model->getActionName($model->parent_id);
                }
            ],
            [
                'header' => Html::a('下级节点数'),
                'content' => function($model){
                    $count = $model->getNextCount($model->action_id);
                    return Html::a($count, ['index', 'pid' => $model->action_id]);
                }
            ],
            'action_code',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Html::a('操作', 'javascript:void(0);'),
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>
    <?php Pjax::end() ?>

</div>
