<?php

use yii\widgets\ListView;
use app\assets\NewsListAsset;

NewsListAsset::register($this);

$this->title = 'Новости';
?>
<div class="row">
    <div class="col-sm-8">
        <?= ListView::widget([
            'dataProvider' => $newsDataProvider,
            'emptyText' => 'Пока нет новостей',
            'emptyTextOptions' => [
                'tag' => 'div',
                'class' => 'newsList__empty -yellow'
            ],
            'itemOptions' => [
                'tag' => 'div',
                'class' => ''
            ],
            'options' => [
                'class' => 'newsList'
            ],
            'pager' => [
                'options' => [
                    'class' => 'newsListPagination'
                ]
            ],
            'layout' => "{items}\n{pager}",
            'itemView' => '_newsItemView'
        ]) ?>
    </div>
    <div class="col-sm-4">
        <?= $this->render('_categoryList', [
            'categories' => $categories,
            'currentCategory' => $currentCategory
        ]) ?>
    </div>
</div>

