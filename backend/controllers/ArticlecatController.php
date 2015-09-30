<?php

namespace backend\controllers;

use common\models\Nav;
use Yii;
use common\models\ArticleCat;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ArticlecatController implements the CRUD actions for ArticleCat model.
 */
class ArticlecatController extends CommonController
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
     * Lists all ArticleCat models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new ArticleCat();

        Yii::$app->view->params['meta_title'] = '文章分类';

        $catList = $model->parent(0, false);

        return $this->render('index', [
            'model' => $model,
            'list' => $catList
        ]);
    }

    /**
     * Creates a new ArticleCat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new ArticleCat();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if ($model->show_in_nav == 1) {
                $Nav = new Nav();
                $Nav->addData('a', $model->cat_id);
            }

            Yii::$app->session->setFlash('success', '添加成功');

            return $this->redirect(['index']);
        } else {

            Yii::$app->view->params['meta_title'] = '添加文章分类';

            $catList = $model->parent(1);

            return $this->render('create', [
                'model' => $model,
                'catList' => $catList
            ]);
        }
    }

    /**
     * Updates an existing ArticleCat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $Nav = new Nav();
            if ($model->show_in_nav == 1) {

                $Nav->addData('a', $model->cat_id);
            } else {
                $Nav->delData('a', $model->cat_id);
            }

            Yii::$app->session->setFlash('success', '编辑成功');

            return $this->redirect(['index']);
        } else {

            Yii::$app->view->params['meta_title'] = '编辑文章分类';

            $catList = $model->parent(1);

            return $this->render('update', [
                'model' => $model,
                'catList' => $catList
            ]);
        }
    }

    /**
     * Deletes an existing ArticleCat model.
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
     * Finds the ArticleCat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ArticleCat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ArticleCat::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * 修改是否在导航栏显示状态
     * @param $cat_id
     * @param int $status
     */
    public function actionSetnav($cat_id, $status = 1){
        $model = new ArticleCat();
        if ($model->show_in_nav($cat_id, $status)) {
            echo '1';
        } else {
            echo '0';
        }
    }

}
