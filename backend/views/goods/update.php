<?php

use yii\helpers\Html;

$this->title = $this->params['meta_title'] . $this->exTitle;

$this->params['breadcrumbs'][] = ['label' => '商品列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->params['meta_title'];
?>
<div class="goods-update">

    <div class="main_title_wrapper clear">

        <h3><?= Html::encode($this->params['meta_title']) ?></h3>
        <p class="action">
            <?=Html::a('商品列表', ['index'], ['class' => 'btn btn-success']) ?>
        </p>

    </div>

    <hr>

    <?= $this->render('_form', [
        'model' => $model,
        'GoodsGallery' => $GoodsGallery,
        'categoryList' => $categoryList,
        'brandList' => $brandList,
        'goodsTypeList' => $goodsTypeList,
        'goodsGalleryList' => $goodsGalleryList
    ]) ?>

</div>
