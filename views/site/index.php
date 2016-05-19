<?php

/* @var $this yii\web\View */

$this->title = \Yii::$app->name;
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Markedoc</h1>

        <p class="lead">一个基于Markdown语法的在线文档管理系统</p>

        <p><a class="btn btn-lg btn-success" href="/page/view?id=1">查看示例</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>多项目</h2>

                <p>一个账号可以创建多个项目。</p>

                <p><a class="btn btn-default" href="/page/view?id=1">详细 &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>多成员</h2>

                <p>项目可以添加多个成员。</p>

                <p><a class="btn btn-default" href="/page/view?id=1">详细 &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>版本控制</h2>

                <p>标记版本号，随时切换到旧版本。</p>

                <p><a class="btn btn-default" href="/page/view?id=1">详细 &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
