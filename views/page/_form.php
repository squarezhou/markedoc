<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Page;
use app\models\Category;

/* @var $this yii\web\View */
/* @var $model app\models\Page */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="page-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')->dropDownList(Category::getOptions(), ['prompt'=>'请选择']) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <div id="page-editormd">
        <textarea name="Page[content]" style="display:none;"><?= $model->content ?></textarea>
    </div>

    <?= $form->field($model, 'status')->radioList(Page::$config_status) ?>

    <?= $model->isNewRecord ? $form->field($model, 'version_code')->textInput(['maxlength' => true]) : $form->field($model, 'version_code')->textInput(['maxlength' => true, 'readonly' => 'readonly']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= $model->isNewRecord ? '' : Html::button('保存到版本', [
            'class' => 'btn btn-success',
            'data-toggle' => 'modal',
            'data-target' => '#page-SaveToVersion',
        ]); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
    $this->registerCssFile("/lib/editor.md-1.5.0/css/editormd.min.css");
    $this->registerJsFile("/lib/editor.md-1.5.0/editormd.min.js", ["depends" => ['yii\web\YiiAsset']]);
    $this->registerJs('
        var testEditor;

        $(function() {
            testEditor = editormd("page-editormd", {
                width   : "100%",
                height  : 640,
                syncScrolling : "single",
                path    : "/lib/editor.md-1.5.0/lib/",
                toolbarIcons : function() {
                    return ["undo", "redo", "|", "preview", "watch", "fullscreen"]
                },
                onfullscreen : function() {
                    $("nav").hide();
                },

                onfullscreenExit : function() {
                    $("nav").show();
                }
            });
        });
    ');
?>
