<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Управление категориями';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать категорию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => 'Категории с <b>{begin}</b> по <b>{end}</b> из <b>{totalCount}</b>.',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            'description:ntext',
            [
                'attribute' => 'active',
                'format' => ['boolean'],
                'filter' => [1 => 'Да', 0 => 'Нет'],
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
