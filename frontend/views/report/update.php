<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\JobProcessing */

$this->title = 'Update Job Processing: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Job Processings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="job-processing-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
