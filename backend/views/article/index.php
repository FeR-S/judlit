<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Articles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'title',
            'slug',
//            'body',
//            'user_id',
            [
                'attribute' => 'category_id',
                'value' => function($model){
                    return $model->category ? $model->category->title : '-';
                }
            ],
            // 'created_at',
            // 'updated_at',
            // 'source',
            // 'rating',
            // 'views',
            [
                'attribute' => 'status',
                'value' => function($model){
                    return \common\models\Article::getStatuses()[$model->status];
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
