<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\PostSearch */
/* @var $form yii\widgets\ActiveForm */
/* @var $tagsArray array */
/* @var $tagCheck string */
?>

<div class="post-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'updated_at')->widget(DatePicker::classname(), [
        'options' => ['value' => $date, 'placeholder' => 'Enter date ...'],
        'pluginOptions' => [
            'autoclose'=>true,
        ]
    ]) ?>

    <?= $form->field($model, 'tags[]')
        ->dropDownList($tagsArray,
            [
                'multiple' => 'multiple',
                'value' => $tagCheck,
            ]
        )  ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Reset','/site/index', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
