<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\NewsPageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Новости';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-sm-8">
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'emptyText' => '<div>Пока нет новостей</div>',
            'itemOptions' => ['class' => 'item'],
            'layout' => "{items}\n{pager}",
            'itemView' => '_view'
        ]) ?>
    </div>
    <div class="col-sm-4">
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'emptyText' => '<div>Пока нет новостей</div>',
            'itemOptions' => ['class' => 'item'],
            'layout' => "{items}\n{pager}",
            'itemView' => '_viewOne'
        ]) ?>
    </div>
</div>

