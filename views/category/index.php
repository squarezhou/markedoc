<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Category;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '分类';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

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
                    return $model->project->name;
                },
            ],
            'name',
            'sort_order',
            [
                'label'=>'状态',
                'format'=>'raw',
                'value'=> function($model) {
                    return Category::$config_status_icon[$model->status];
                },
            ],
            [
                'label'=>'创建时间',
                'value'=> function($model) {
                    return !empty($model->created_at) ? date('Y-m-d H:i:s', $model->created_at) : '';
                },
            ],
            // 'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {view} {category-pages}',
                'buttons' => [
                    'category-pages' => function ($url, $model, $key) {
                        $options = [
                            'title' => '查看页面',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-file"></span>', '/page?category_id='.$model->id, $options);
                    },
                ]
            ],
        ],
    ]); ?>

</div>
