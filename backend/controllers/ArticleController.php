<?php

namespace backend\controllers;

use common\models\ArticleCat;
use Yii;
use common\models\Article;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends CommonController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $query = Article::find();

        if ($_GET['cat_id'] > 0) {
            $query = $query->where('cat_id = :cat_id', [':cat_id' => $_GET['cat_id']]);
        }
        if (!empty($_GET['title'])) {
            $query = $query->andWhere("title like '%{$_GET['title']}%'");
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        Yii::$app->view->params['meta_title'] = '文章列表';

        $ArticleCat = new ArticleCat();

        $catList = $ArticleCat->parentNews(0);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'catList' => $catList
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Article();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            Yii::$app->session->setFlash('success', '添加成功');

            return $this->redirect(['index']);
        } else {

            Yii::$app->view->params['meta_title'] = '添加新文章';

            $ArticleCat = new ArticleCat();

            $catList = $ArticleCat->parent(0, false);

            return $this->render('create', [
                'model' => $model,
                'catList' => $catList
            ]);
        }
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            Yii::$app->session->setFlash('success', '编辑成功');

            return $this->redirect(['index']);
        } else {

            Yii::$app->view->params['meta_title'] = '编辑文章';

            $ArticleCat = new ArticleCat();

            $catList = $ArticleCat->parent(0, false);

            return $this->render('update', [
                'model' => $model,
                'catList' => $catList
            ]);
        }
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * 热门状态修改
     * @param $article_id
     * @param int $status
     */
    public function actionHot($article_id, $status = 1){
        $model = new Article();

        if ($model->setHot($article_id, $status)) {
            echo '1';
        } else {
            echo '0';
        }
    }

    /**
     * 显示状态修改
     * @param $article_id
     * @param int $status
     */
    public function actionStatus($article_id, $status = 1){
        $model = new Article();

        if ($model->setStatus($article_id, $status)) {
            echo '1';
        } else {
            echo '0';
        }
    }
}
