<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;
/* @var $this yii\web\View */
/* @var $model common\models\Article */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row" style="margin-top: 30px">
    <div class="col-xs-8">
        <section class="blog-post">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="blog-post-meta">
                        <span class="label label-light label-warning"><?php echo $model->category->title; ?></span>
                        <p class="blog-post-date pull-right"><?php echo $model->created_at; ?></p>
                    </div>
                    <div class="blog-post-content">
                        <h2 class="blog-post-title"><?php echo $model->title; ?></h2>
                        <p><?php echo $model->body; ?></p>
                        <p><?php echo $model->source; ?></p>
                        <p><?php echo $model->user->username; ?></p>
                    </div>
                </div>
                <img src="<?php echo $model->getImagePath($model->id); ?>" data-holder-rendered="true">
            </div>
        </section>
    </div>
    <div class="col-xs-4">
        <div class="sidebar-module">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4>Categories</h4>
                    <ol class="categories list-unstyled">
                        <?= ListView::widget([
                            'dataProvider' => $categories,
                            'summary' => false,
                            'options' => [
                                'class' => 'categories list-unstyled',
                                'tag' => 'ol'
                            ],
                            'itemView' => '/category\_category-item',
                        ]) ?>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

if (!Yii::$app->user->isGuest) {
//    if(Yii::$app->user->identity->role == \common\models\User::ROLE_ADMIN){
    echo Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
//    }
}

?>

