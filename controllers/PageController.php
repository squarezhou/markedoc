<?php

namespace app\controllers;

use app\models\Category;
use app\models\PageStvForm;
use app\models\Project;
use Yii;
use app\models\Page;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PageController implements the CRUD actions for Page model.
 */
class PageController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'save-to-version', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Page models.
     * @return mixed
     */
    public function actionIndex()
    {
        $category_id = Yii::$app->request->get('category_id', 0);

        $where = [];
        if (!empty($category_id)) {
            $where['category_id'] = $category_id;
        }

        $dataProvider = new ActiveDataProvider([
            'query' => Page::find()->where(['user_id' => Yii::$app->user->identity->id, 'version' => 'latest'])->andWhere($where),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Page model.
     * @param integer $id
     * @return mixed
     */
    public function actionView()
    {
        $id = Yii::$app->request->get('id', 0);
        $category_id = Yii::$app->request->get('category_id', 0);
        $project_id = Yii::$app->request->get('project_id', 0);
        if (!empty($id)) {
            $model = $this->findModel($id);
            $project = $model->category->project;
            $categorys = Category::find()->where(['project_id' => $model->category->project->id, 'status' => Category::STATUS_ACTIVE])->all();
        } else {
            $model = new Page();
            if (!empty($category_id)) {
                $category = Category::findOne($category_id);
                if (!empty($category)) {
                    $project = $category->project;
                    $categorys = Category::find()->where(['project_id' => $category->project->id, 'status' => Category::STATUS_ACTIVE])->all();
                } else {
                    return $this->goBack();
                }
            } elseif (!empty($project_id)) {
                $project = Project::findOne($project_id);
                if (!empty($project)) {
                    $categorys = Category::find()->where(['project_id' => $project->id, 'status' => Category::STATUS_ACTIVE])->all();
                } else {
                    return $this->goBack();
                }
            } else {
                return $this->goBack();
            }
        }



        return $this->renderPartial('view', [
            'model' => $model,
            'project' => $project,
            'categorys' => $categorys,
        ]);
    }

    /**
     * Creates a new Page model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Page();

        if ($model->load(Yii::$app->request->post())) {
            $model->page_id = 0;
            $model->version = 'latest';
            $model->user_id = Yii::$app->user->identity->id;
            if ($model->save()) {
                $model->page_id = $model->id;
                $model->save();
                return $this->redirect(['index']);
            }
        } else {
            $template = file_get_contents("../templates/default.md");
            $model->content = $template;
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Page model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->user_id != Yii::$app->user->identity->id) {
            return;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $stvForm = new PageStvForm();
            $stvForm->id = $model->id;
            $stvForm->version_code = $model->version_code;
            return $this->render('update', [
                'model' => $model,
                'stvForm' => $stvForm,
            ]);
        }
    }

    public function actionSaveToVersion()
    {
        $form = new PageStvForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $model = $this->findModel($form->id);
            if ($model->user_id != Yii::$app->user->identity->id) {
                return;
            }

            $exist = Page::find()->where(['page_id' => $model->page_id, 'version_code' => $form->to_version_code])->exists();
            if ($exist) {
                return json_encode(['status' => -1, 'data' => [], 'message' => '版本号已存在！']);
            }

            $model->version = '';
            $model->save();

            $model->isNewRecord = true;
            $model->id = null;
            $model->version_code = $form->to_version_code;
            $model->version = 'latest';
            $model->content = $form->content;
            $model->save();

            return json_encode(['status' => 0, 'data' => ['id' => $model->id], 'message' => '版本号已存在！']);
        }
    }

    /**
     * Deletes an existing Page model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->user_id != Yii::$app->user->identity->id) {
            return;
        }

        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Page model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Page the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Page::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
