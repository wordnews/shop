<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Region;

$this->title = $this->params['meta_title'] . $this->exTitle;

$this->params['breadcrumbs'][] = $this->params['meta_title'];
?>
<div class="region-index">

    <?php Pjax::begin() ?>
    <div class="main_title_wrapper clear">
        <h3><?= Html::encode($this->params['meta_title']) ?></h3>
    
        <p class="action">
            <?= Html::a('增加地区', ['create', 'parent_id' => $_GET['parent_id']], ['class' => 'btn btn-success']) ?>

            <?= Html::a('返回一级地区', ['index'], ['class' => 'btn btn-warning']) ?>
        </p>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'region_id',
            [
                'header' => Html::a('上级地区'),
                'content' => function ($model) {
                    $region = Region::findOne($model->parent_id);
                    return Html::a($region->region_name);
                }
            ],
            [
                'header' => Html::a('地区名字'),
                'content' => function ($model) {
                    return Html::a($model->region_name, ['index', 'parent_id' => $model->region_id]);
                }
            ],
            'region_type',
//            'agency_id',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Html::a('操作', 'javascript:void(0);'),
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>
    <?php Pjax::end() ?>

</div>
