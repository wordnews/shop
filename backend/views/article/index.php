<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\ArticleCat;

$this->title = $this->params['meta_title'] . $this->exTitle;

$this->params['breadcrumbs'][] = $this->params['meta_title'];
?>
<div class="article-index">

    <div class="main_title_wrapper clear">
        <h3><?= Html::encode($this->params['meta_title']) ?></h3>
    
        <p class="action">
            <?= Html::a('添加新文章', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    </div>

    <div class="form-div">

        <form action="">

            <?= Html::img('@web/image/icon_search.gif', [
                'width' => 26,
                'height' => 22,
                'border' => 0,
                'alt' => ''
            ]) ?>

            <?= Html::decode(Html::dropDownList('cat_id', $_GET['cat_id'], $catList)) ?>

            文章标题
            <input type="text" name="title" size="15" placeholder="<?= $_GET['title'] ? $_GET['title'] : '标题关键字'; ?>">

            <input type="submit" value=" 搜索 " class="button">

        </form>

    </div>

    <?php Pjax::begin() ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'name' => 'id'
            ],

            'article_id',
            'title',
            [
                'header' => Html::a('文章分类', 'javascript:void(0);'),
                'content' => function ($model) {
                    return ArticleCat::findOne($model->cat_id)->cat_name;
                }
            ],
            [
                'header' => Html::a('文章类型', 'javascript:void(0);'),
                'content' => function ($model) {
                    $typeList = [
                        '0' => '普通',
                        '1' => '置顶'
                    ];
                    return $typeList[$model->article_type];
                }
            ],
            [
                'header' => Html::a('是否热门', 'javascript:void(0);'),
                'content' => function ($model) {
                    if ($model->is_hot == 1) {
                        return Html::img('@web/image/yes.gif', [
                            'onclick' => "setHot(this, {$model->article_id})",
                            'data-status' => 0
                        ]);
                    }
                    return Html::img('@web/image/no.gif', [
                        'onclick' => "setHot(this, {$model->article_id})",
                        'data-status' => 1
                    ]);
                }
            ],
            [
                'header' => Html::a('是否显示', 'javascript:void(0);'),
                'content' => function ($model) {
                    if ($model->status == 1) {
                        return Html::img('@web/image/yes.gif', [
                            'onclick' => "setStatus(this, {$model->article_id})",
                            'data-status' => 0
                        ]);
                    }
                    return Html::img('@web/image/no.gif', [
                        'onclick' => "setStatus(this, {$model->article_id})",
                        'data-status' => 1
                    ]);
                }
            ],
            'add_time:datetime',


            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Html::a('操作', 'javascript:void(0);'),
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>
    <?php Pjax::end() ?>

</div>

<?php $this->beginBlock('js_end') ?>

function setHot(objs, id){
    var obj = $(objs);
    var status = obj.attr('data-status');
    $.get("<?= Url::to(['hot']) ?>", {article_id:id, status:status}, function(re){
        if (re == 1) {
            if (status == 1) {
                obj.attr({src:"<?= Url::to('@web/image/yes.gif') ?>", 'data-status':0});

            }else {
                obj.attr({src:"<?= Url::to('@web/image/no.gif') ?>", 'data-status':1});

            }
        }
    });
}

function setStatus(objs, id){
    var obj = $(objs);
    var status = obj.attr('data-status');
    $.get("<?= Url::to(['status']) ?>", {article_id:id, status:status}, function(re){
        if (re == 1) {
            if (status == 1) {
                obj.attr({src:"<?= Url::to('@web/image/yes.gif') ?>", 'data-status':0});

            }else {
                obj.attr({src:"<?= Url::to('@web/image/no.gif') ?>", 'data-status':1});

            }
        }
    });
}

<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['js_end'], $this::POS_END); ?>