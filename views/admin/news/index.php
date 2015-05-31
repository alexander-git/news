<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\utils\formatters\NewsFormatter;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Управление новостями';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php /* echo $this->render('_search', [
        'model' => $searchModel,
        'categories' => $categories
    ]) */?>

    <p>
        <?= Html::a('Создать новость', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => 'Новости с <b>{begin}</b> по <b>{end}</b> из <b>{totalCount}</b>.',
        'formatter' => new NewsFormatter(),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            'description:ntext',
            [
                'attribute' => 'active',
                'format' => ['boolean'],
                'filter' => [1 => 'Да', 0 => 'Нет'],
            ],
            [
                'attribute' => 'createdAt',
                'format' => 'datetime',
                'filter' => false
            ],
            [
                'attribute' => 'hasImage',
                'format' => ['boolean'],
                'filter' => [1 => 'Да', 0 => 'Нет'],
            ],
            [
                'attribute' => 'category',
                'label' => 'Категории',
                'format' => 'paragraphs',
                'value' => function($newsModel) {
                    $result = '';
                    foreach ($newsModel->categories as $c) {
                        $result .= $c->title."\n\n";
                    }
                    return $result;
                },
                'filter' => $categories
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
