<?php

use yii\helpers\Html;


$this->title = $this->params['meta_title'] . $this->exTitle;
$this->params['breadcrumbs'][] = ['label' => '友情链接列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->params['meta_title'];
?>
<div class="friend-link-create">

    <div class="main_title_wrapper clear">

        <h3><?= Html::encode($this->params['meta_title']) ?></h3>

        <p class="action">
            <?= Html::a('友情链接列表', ['index'], ['class' => 'btn btn-warning']) ?>
        </p>

    </div>

    <hr>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
