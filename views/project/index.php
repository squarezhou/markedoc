<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Project;
use app\models\User;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '项目';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">

    <p>
        <?= Html::a('创建', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label'=>'创建者',
                'value'=> function($model) {
                    return $model->user->username;
                },
            ],
            'name',
            'description:ntext',
            [
                'label'=>'成员',
                'value'=> function($model) {
                    return User::getNames($model->members);
                },
            ],
            // 'password',
            [
                'label'=>'状态',
                'format'=>'raw',
                'value'=> function($model) {
                    return Project::$config_status_icon[$model->status];
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
                'template' => '{update} {view} {prject-categorys}',
                'buttons' => [
                    'prject-categorys' => function ($url, $model, $key) {
                        $options = [
                            'title' => '查看分类',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-list"></span>', '/category?project_id='.$model->id, $options);
                    },
                ]
            ],
        ],
    ]); ?>

</div>
