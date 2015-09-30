<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

echo "<?php\n";
?>

use yii\helpers\Html;


$this->title = $this->params['meta_title'] . $this->exTitle;

$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-create">

    <div class="main_title_wrapper clear">

        <h3><?= "<?= " ?>Html::encode($this->params['meta_title']) ?></h3>
        <p class="action">
            <?= "<?=" ?>Html::a('菜单列表', ['index'], ['class' => 'btn btn-success']) ?>
        </p>

    </div>

    <hr>

    <?= "<?= " ?>$this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
