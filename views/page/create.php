<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Page */

$this->title = '创建';
$this->params['breadcrumbs'][] = ['label' => '页面', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
