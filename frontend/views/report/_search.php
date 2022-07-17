<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\JobProcessingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="job-processing-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'test_type_id') ?>

    <?= $form->field($model, 'job_id') ?>

    <?= $form->field($model, 'number_id') ?>

    <?= $form->field($model, 'call_start_time') ?>

    <?php // echo $form->field($model, 'call_connect_time') ?>

    <?php // echo $form->field($model, 'call_end_time') ?>

    <?php // echo $form->field($model, 'call_description_id') ?>

    <?php // echo $form->field($model, 'created_on') ?>

    <?php // echo $form->field($model, 'updated_on') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
