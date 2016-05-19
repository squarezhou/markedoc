<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Project */

$this->title = '创建';
$this->params['breadcrumbs'][] = ['label' => '项目', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
