<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $tagsArray array */
/* @var $date string */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', [
        'model' => $searchModel,
        'tagsArray' => $tagsArray,
        'tagCheck' => $tagCheck,
        'date' => $date
    ]); ?>

    <? if (!Yii::$app->user->isGuest) { ?>
        <p>
            <?= Html::a('Create Post', ['post/create'], ['class' => 'btn btn-success']) ?>
        </p>
    <? } ?>

    <div class="row">
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'col-md-4 text-center'],
            'itemView' => '_item',
        ]) ?>
    </div>

</div>
