<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\JobProcessing */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="job-processing-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'test_type_id')->textInput() ?>

    <?= $form->field($model, 'job_id')->textInput() ?>

    <?= $form->field($model, 'number_id')->textInput() ?>

    <?= $form->field($model, 'call_start_time')->textInput() ?>

    <?= $form->field($model, 'call_connect_time')->textInput() ?>

    <?= $form->field($model, 'call_end_time')->textInput() ?>

    <?= $form->field($model, 'call_description_id')->textInput() ?>

    <?= $form->field($model, 'created_on')->textInput() ?>

    <?= $form->field($model, 'updated_on')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
