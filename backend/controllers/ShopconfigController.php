<?php

namespace backend\controllers;

use Yii;
use common\models\ShopConfig;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ShopconfigController implements the CRUD actions for ShopConfig model.
 */
class ShopconfigController extends Controller
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
     * Lists all ShopConfig models.
     * @return mixed
     */
    public function actionIndex()
    {

        $model = new ShopConfig();

        if (Yii::$app->request->isPost) {

            $model->editData($_POST['ShopConfig']);

            $this->redirect(['index']);
        }
        $model->setData();

        Yii::$app->view->params['meta_title'] = '商店设置';

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new ShopConfig model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ShopConfig();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            Yii::$app->session->setFlash('success', '添加成功');

            return $this->redirect(['index']);
        } else {

            Yii::$app->view->params['meta_title'] = '创建';

            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ShopConfig model.
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

            Yii::$app->view->params['meta_title'] = '编辑配置';

            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ShopConfig model.
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
     * Finds the ShopConfig model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ShopConfig the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ShopConfig::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
