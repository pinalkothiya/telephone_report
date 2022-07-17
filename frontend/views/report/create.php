<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\JobProcessing */

$this->title = 'Create Job Processing';
$this->params['breadcrumbs'][] = ['label' => 'Job Processings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-processing-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
