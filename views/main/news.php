<?php

use yii\helpers\Html;
use app\assets\NewsAsset;

NewsAsset::register($this);

$this->title = $model->title;
?>
<div class="news -yellow">
    <div class="news__header -clearfix">
        <div class="news__title">
            <?= Html::encode($model->title) ?>
        </div>
        <div class="news__date">
            <?= $model->date ?>
        </div>
    </div>
    <div class="news__content -clearfix">
        <?php /*
        <?php if ($model->hasImage) : ?>
            <?= Html::img($model->imageUrl, ['class' => 'news__image']) ?>
        <?php endif; ?>
        */?>
        <div class="news__text">
            <?= Html::encode($model->text) ?>
        </div>
    </div>
</div>
