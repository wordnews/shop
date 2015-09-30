<?php

namespace backend\controllers;

use Yii;
use common\models\Region;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AreaController implements the CRUD actions for Region model.
 */
class AreaController extends Controller
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
     * Lists all Region models.
     * @return mixed
     */
    public function actionIndex($parent_id = 0)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Region::find()->where(['parent_id' => $parent_id]),
        ]);

        Yii::$app->view->params['meta_title'] = '地区列表';

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Region model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Region();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            Yii::$app->session->setFlash('success', '添加成功');

            return $this->redirect(['index', 'parent_id' => $_GET['parent_id']]);
        } else {

            Yii::$app->view->params['meta_title'] = '增加地区';

            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Region model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            Yii::$app->session->setFlash('success', '编辑成功');

            return $this->redirect(['index', 'parent_id' => $model->parent_id]);
        } else {

            Yii::$app->view->params['meta_title'] = '编辑地区';

            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Region model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $Region = new Region();
        // 有子地区不允许删除
        if ($Region->find()->where(['parent_id' => $id])->one()) {

            Yii::$app->session->setFlash('error', '请先删除下面的子地区');
        } else {

            $this->findModel($id)->delete();
        }

        return $this->redirect(['index', 'parent_id' => $id]);
    }

    /**
     * Finds the Region model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Region the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Region::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
