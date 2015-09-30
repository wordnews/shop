<?php

use yii\helpers\Html;


$this->title = $this->params['meta_title'] . $this->exTitle;

$this->params['breadcrumbs'][] = ['label' => '会员等级', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->params['meta_title'];
?>
<div class="member-rank-create">

    <div class="main_title_wrapper clear">

        <h3><?= Html::encode($this->params['meta_title']) ?></h3>
        <p class="action">
            <?=Html::a('会员等级', ['index'], ['class' => 'btn btn-success']) ?>
        </p>

    </div>

    <hr>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
