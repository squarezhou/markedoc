<?php

use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Page */

$this->title = '更新: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => $model->category->project->name, 'url' => ['/project/view', 'id' => $model->category->project->id]];
$this->params['breadcrumbs'][] = ['label' => $model->category->name, 'url' => ['/category/view', 'id' => $model->category->id]];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="page-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<div class="modal fade" id="page-SaveToVersion">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php $form = ActiveForm::begin([
                'action' => 'save-to-version'
            ]); ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="关闭">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">保存到版本</h4>
            </div>
            <div class="modal-body">
                <input name="PageStvForm[id]" type="hidden" value="<?= $model->id ?>">
                <input name="PageStvForm[content]" id="pagestvform-content" type="hidden" value="">
                <?= $form->field($stvForm, 'version_code')->textInput(['maxlength' => true, 'readonly' => 'readonly']) ?>
                <?= $form->field($stvForm, 'to_version_code')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="submit" class="btn btn-danger">保存</button>
            </div>
            <?php ActiveForm::end(); ?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php
    $this->registerJs('
        $("#page-SaveToVersion").on("shown.bs.modal", function(e) {
            $("#pagestvform-to_version_code").focus();
        });
        $("#page-SaveToVersion form").on("beforeSubmit", function (e) {
            $("#pagestvform-content").val($("#page-editormd>textarea").val());
            var $form = $(this);
            $.post(
                $form.attr("action"),
                $form.serializeArray(),
                function (data) {
                    if (data.status == 0) {
                        window.location.href = "/page/update?id=" + data.data.id;
                    } else {
                        alert(data.message);
                    }
                },
                "json"
            );
        }).on("submit", function (e) {
            e.preventDefault();
        });
    ');
?>