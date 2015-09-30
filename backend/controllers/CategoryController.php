<?php

namespace backend\controllers;

use common\models\Nav;
use Yii;
use common\models\CatRecommend;
use common\models\Category;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
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
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Category();

        $list = $model->parent(0, false);

        Yii::$app->view->params['meta_title'] = '商品分类';

        return $this->render('index', [
            'list' => $list,
        ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Category();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            // 加入分类推荐
            $CatRecommend = new CatRecommend();
            $CatRecommend->insertRecommend($model->cat_id, $_POST['Category']['recommend_type']);

            // 是否需要显示在导航栏
            if ($model->show_in_nav == 1) {
                $Nav = new Nav();
                $Nav->addData('c', $model->cat_id);
            }

            Yii::$app->session->setFlash('success', '添加成功');

            return $this->redirect(['index']);
        } else {

            Yii::$app->view->params['meta_title'] = '添加分类';

            $catList = $model->parent(0);

            return $this->render('create', [
                'model' => $model,
                'catList' => $catList
            ]);
        }
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $CatRecommend = new CatRecommend();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            // 加入分类推荐
            $CatRecommend->insertRecommend($model->cat_id, $_POST['Category']['recommend_type']);

            // 是否需要显示在导航栏
            $Nav = new Nav();
            if ($model->show_in_nav == 1) {

                $Nav->addData('c', $model->cat_id);
            } else {
                $Nav->delData('c', $model->cat_id);
            }

            Yii::$app->session->setFlash('success', '编辑成功');

            return $this->redirect(['index']);
        } else {
            $model->recommend_type = $CatRecommend->catRecommend($id);

            Yii::$app->view->params['meta_title'] = '编辑分类';

            $catList = $model->parent(0);

            return $this->render('update', [
                'model' => $model,
                'catList' => $catList,
            ]);
        }
    }

    /**
     * Deletes an existing Category model.
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
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
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
        $model = new Category();
        if ($model->show_in_nav($cat_id, $status)) {
            echo '1';
        } else {
            echo '0';
        }
    }

    /**
     * 修改是否显示状态
     * @param $cat_id
     * @param int $status
     */
    public function actionStatus($cat_id, $status = 1){
        $model = new Category();
        if ($model->is_show($cat_id, $status)) {
            echo '1';
        } else {
            echo '0';
        }
    }

}
