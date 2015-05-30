<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\search\NewsSearch */
/* @var $form yii\widgets\ActiveForm */

$categoriesListData = ArrayHelper::merge(['' => 'Любая'], $categories );

?>

<div class="news-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'active')->dropDownList(['' => 'Не важно', 1 => 'Да', 0 => 'Нет']) ?>
    
    <?= $form->field($model, 'hasImage')->dropDownList(['' => 'Не важно', 1 => 'Да', 0 => 'Нет']) ?>

    <?= $form->field($model, 'category')->dropDownList($categoriesListData) ?>
        
    <div class="form-group">
        <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Очистить', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
