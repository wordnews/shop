<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form shop-form">

    <?= "<?php " ?>$form = ActiveForm::begin([
        'options' => [
            'class' => 'form-horizontal',
        ],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-xs-5\">{input}</div>\n{hint}\n{error}",
        ]
    ]); ?>

<?php foreach ($generator->getColumnNames() as $attribute) {
    if (in_array($attribute, $safeAttributes)) {
        echo "    <?= " . $generator->generateActiveField($attribute) . "->label(null, [
        'class' => 'col-sm-2 control-label'
    ]) ?>\n\n";
        }
    } ?>
    <div class="form-group">
        <div class="col-xs-2"></div>
        <?= "<?= " ?>Html::submitButton($model->isNewRecord ? <?= $generator->generateString('确 定') ?> : <?= $generator->generateString('更 新') ?>, ['class' => $model->isNewRecord ? 'btn btn-success word-btn' : 'btn btn-primary word-btn']) ?>
        <?= "<?= " ?>Html::a('返 回', 'javascript:history.back(-1)', ['class' => 'btn btn-warning']) ?>
    </div>

    <?= "<?php " ?>ActiveForm::end(); ?>

</div>
