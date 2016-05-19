<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/favicon.ico">

    <title><?= $model->title ?></title>

    <!-- Bootstrap core CSS -->
    <link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="/lib/editor.md-1.5.0/css/editormd.preview.min.css" />

    <style>
        body {
            padding-top: 0;
        }

        .editormd-html-preview {
            width: auto;
            margin-right: 300px;
        }

        #sidebar {
            width: 400px;
            height: 100%;
            position: fixed;
            top: 0;
            right: 0;
            overflow: hidden;
            background: #fff;
            z-index: 100;
            padding: 18px;
            border: 1px solid #ddd;
            border-top: none;
            border-bottom: none;
        }

        #sidebar:hover {
            overflow: auto;
        }

        #sidebar h1 {
            font-size: 16px;
        }

        #custom-toc-container {
            padding-left: 0;
        }
    </style>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<!-- Fixed navbar -->
<nav class="navbar navbar-inverse navbar-fixed-bottom">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="javascript:void(0);"><?= $project->name ?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <?php foreach($categorys as $category): ?>
                    <?php if (!empty($category->pages)): ?>
                        <li class="dropdown<?= ($category->id == $model->category_id) ? ' active' : '' ?>">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= $category->name ?> <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <?php foreach($category->pages as $page): ?>
                                <li<?= ($model->page_id == $page->page_id) ? ' class="active"' : '' ?>><a href="/page/view?id=<?= $page->id ?>"><?= $page->title ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li<?= ($category->id == $model->category_id) ? ' class="active"' : '' ?>><a href="javascript:void(0);"><?= $category->name ?></a></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if (Yii::$app->user->isGuest): ?>
                    <li><a href="/site/signup">注册</a></li>
                    <li><a href="/site/login">登录</a></li>
                <?php else: ?>
                    <li><a href="/project">切换项目</a></li>
                <?php endif; ?>
                <li><a href="<?= Yii::$app->homeUrl ?>">回首页</a></li>

                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">版本号 <?= $model->version_code ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php foreach($model->versions as $page): ?>
                            <li<?= ($model->version_code == $page->version_code) ? ' class="active"' : '' ?>><a href="/page/view?id=<?= $page->id ?>"><?= $page->version_code ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container">

    <div id="sidebar">
        <h1>目录</h1>
        <div class="markdown-body editormd-preview-container" id="custom-toc-container">#custom-toc-container</div>
    </div>

    <div id="editormd-view">
		<textarea style="display:none;" name="editormd-markdown-doc"><?= $model->content ?></textarea>
    </div>

</div> <!-- /container -->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<script src="/lib/editor.md-1.5.0/lib/marked.min.js"></script>
<script src="/lib/editor.md-1.5.0/lib/prettify.min.js"></script>

<script src="/lib/editor.md-1.5.0/lib/raphael.min.js"></script>
<script src="/lib/editor.md-1.5.0/lib/underscore.min.js"></script>
<script src="/lib/editor.md-1.5.0/lib/sequence-diagram.min.js"></script>
<script src="/lib/editor.md-1.5.0/lib/flowchart.min.js"></script>
<script src="/lib/editor.md-1.5.0/lib/jquery.flowchart.min.js"></script>

<script src="/lib/editor.md-1.5.0/editormd.min.js"></script>
<script type="text/javascript">
    $(function() {
        var editormdView;
        editormdView = editormd.markdownToHTML("editormd-view", {
            htmlDecode      : "style,script,iframe",  // you can filter tags decode
            tocContainer    : "#custom-toc-container",
            emoji           : true,
            taskList        : true,
            tex             : true,  // 默认不解析
            flowChart       : true,  // 默认不解析
            sequenceDiagram : true,  // 默认不解析
        });
    });
</script>

</body>
</html>
