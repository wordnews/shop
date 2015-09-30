<?php

namespace backend\controllers;

use common\helpers\File;
use Yii;
use common\models\Brand;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BrandController implements the CRUD actions for Brand model.
 */
class BrandController extends CommonController
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
     * Lists all Brand models.
     * @return mixed
     */
    public function actionIndex($brand_name = '')
    {
        if (empty($brand_name)) {
            $query = Brand::find();
        }else
            $query = Brand::find()->where("brand_name like '%{$brand_name}%'");

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        Yii::$app->view->params['meta_title'] = '商品品牌';

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Brand model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Brand();

        if ($model->load(Yii::$app->request->post())) {

            /* 处理上传的图片 */
            if ($_FILES['Brand']['error']['brand_logo'] === 0) {
                /* 把文件的路劲赋值给image字段 */
                $model->brand_logo = File::uploadImage($model, 'brand_logo', 'other');
            }
            if ($model->save()) {
                Yii::$app->session->setFlash('success', '添加成功');
            }

            return $this->redirect(['index']);
        } else {

            Yii::$app->view->params['meta_title'] = '添加品牌';

            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Brand model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            /* 处理上传的图片 */
            if ($_FILES['Brand']['error']['brand_logo'] === 0) {
                /* 把文件的路劲赋值给image字段 */
                $model->brand_logo = File::uploadImage($model, 'brand_logo', 'other');
            }
            if ($model->save()) {
                Yii::$app->session->setFlash('success', '编辑成功');
            }

            return $this->redirect(['index']);
        } else {

            Yii::$app->view->params['meta_title'] = '编辑品牌';

            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Brand model.
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
     * Finds the Brand model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Brand the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Brand::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * 修改显示状态
     * @param int $brand_id
     * @param int $status
     */
    public function actionStatus($brand_id, $status = 1){
        $model = new Brand();
        if ($model->setStatus($brand_id, $status)) {
            echo '1';
        } else {
            echo '0';
        }
    }

    /**
     * 修改热销状态
     * @param int $brand_id
     * @param int $status
     */
    public function actionHot($brand_id, $status = 1){
        $model = new Brand();
        if ($model->setHot($brand_id, $status)) {
            echo '1';
        } else {
            echo '0';
        }
    }
}
