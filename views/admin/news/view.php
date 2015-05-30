<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\utils\formatters\NewsFormatter;

/* @var $this yii\web\View */
/* @var $model app\models\News */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить новость?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'formatter' => new NewsFormatter(),
        'attributes' => [
            'title',
            'description',
            'active:boolean',
            [
                'attribute' => 'createdAt',
                'format' => ['datetime', 'j-MM-Y H:i:s'],
            ],

            [
                'label' => 'Категории',
                'format' => 'categories',
                'value' => $model->categories
            ],
            
            [
                'label' => 'Изображение',
                'attribute' => 'imageUrl',
                'format' => 'imageUrl'
            ],

            'text:ntext',
        ],
    ]) ?>

</div>
