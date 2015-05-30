<?php

use yii\helpers\Html;

$newsUrl = ['main/news', 'id' => $model->id];

?>
<div class="newsListItem <?= ($index % 2 === 0) ? '-yellow' : '-lightYellow' ?>">
    <div class="newsListItem__header -clearfix">
        <div class="newsListItem__title">
            <?= Html::a(Html::encode($model->title), $newsUrl) ?>
        </div>
        <div class="newsListItem__date">
            <?= $model->date ?>
        </div>
    </div>
    
    <div class="newsListItem__content -clearfix">
        <?php if ($model->hasImage) : ?>
            <?= Html::a(
                Html::img($model->imageUrl, ['class' => 'newsListItem__image']),
                $newsUrl
            ) ?>
        <?php endif; ?>
        <div class="newsListItem__description">
            <?= Html::encode($model->description) ?>&nbsp;
            <?= Html::a('читать далее', $newsUrl, ['class' => 'newsListItem__readMore']) ?>
        </div>        
    </div>
</div>
