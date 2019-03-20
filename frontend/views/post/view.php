<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Post */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['site/index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="post-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <? if ($model->isMyPost()){?>
        <p>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    <?}?>

    <div class="row">
        <div class="col-md-12 text-center">
            <h2><?= Html::encode($model->title)?></h2>
            <img class="img-rounded" alt="Post image" src="<?= Html::encode($model->getImageSrc())?>" style="width: 340px">
            <p><?= Html::encode($model->text)?></p>
            <?foreach ($model->tags as $tag){?>
                <code><?= Html::encode($tag->name)?></code>
            <?}?>
            <p class="text-muted"><?= Yii::$app->formatter->asDate($model->updated_at)?></p>
        </div>
    </div>
</div>
