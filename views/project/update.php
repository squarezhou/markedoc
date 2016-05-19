<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Project */

$this->title = '更新: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="project-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
