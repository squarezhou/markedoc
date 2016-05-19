<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Page;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '页面';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-index">

    <p>
        <?= Html::a('创建', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label'=>'用户名',
                'value'=> function($model) {
                    return $model->user->username;
                },
            ],
            [
                'label'=>'所属项目',
                'value'=> function($model) {
                    return $model->category->project->name;
                },
            ],
            [
                'label'=>'所属分类',
                'value'=> function($model) {
                    return $model->category->name;
                },
            ],
            'title',
            [
                'label'=>'状态',
                'format'=>'raw',
                'value'=> function($model) {
                    return Page::$config_status_icon[$model->status];
                },
            ],
            'version_code',
            [
                'label'=>'创建时间',
                'value'=> function($model) {
                    return !empty($model->created_at) ? date('Y-m-d H:i:s', $model->created_at) : '';
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
