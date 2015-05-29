<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\News */
/* @var $form yii\widgets\ActiveForm */

$isCreation = $model->isNewRecord;

if (!$isCreation) {
    $fileControlId = 'fileControl';
    $this->render('_fileControlScript', ['fileControlId' => $fileControlId]);
} 

$categoriesListSize = min(count($categories), 10);
?>

<div class="news-form">

    <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data']
    ]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
    
    <?php if (!$isCreation) : ?>  
        <?= $form->field($model, 'createdAt')->textInput() ?>
    <?php endif; ?>
    
    <?php if($isCreation) : ?>
        <?= $form->field($model, 'imageFile')->fileInput() ?>
    <?php else : ?>
        <div id="<?=$fileControlId?>" class="fileControl -marginBottom20">
            <?= $form->field($model, 'imageFile')->fileInput(['class' => 'fileControl__file']) ?>
            <?= Html::input('text', 'imageFilename', $model->imageFilename, ['readonly' => 'readonly', 'class' => 'fileControl__fileName']) ?>
            <div class="-marginTop10">
                <?= Html::button('Удалить', ['class' => 'fileControl__deleteButton']); ?> 
            </div>
        </div>
    <?php endif; ?>
    
    <?= $form->field($model, 'categories')->listBox($categories, [
        'multiple' => 'multiple',
        'size' => $categoriesListSize,
        'autocomplete' => 'off'
    ]) ?>
    
    <?= $form->field($model, 'active')->checkbox() ?>
    
    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton(
                $isCreation ? 'Создать' : 'Обновить', 
                ['class' => ($isCreation ? 'btn btn-success' : 'btn btn-primary')]
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
