<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model \common\models\Post */

?>
<a href="<?= Url::to(['post/view', 'id' => $model->id]) ?>">
    <h5><?= Html::encode($model->title) ?></h5>
    <img class="img-rounded" alt="Post image" src="<?= Html::encode($model->getImageSrc()) ?>" style="width: 140px">
    <p class="text-muted"><?= Yii::$app->formatter->asDate($model->updated_at) ?></p>
</a>
