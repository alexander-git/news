<?php

use yii\helpers\Html;
use yii\grid\GridView;

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
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            'description',
            [
                'attribute' => 'active',
                'format' => ['boolean'],
                'filter' => [1 => 'Да', 0 => 'Нет'],
            ],
            [
                'attribute' => 'createdAt',
                'format' => ['datetime', 'j-MM-Y H:i:s'],
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
