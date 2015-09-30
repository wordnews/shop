<?php

namespace backend\controllers;

use Yii;
use common\models\RoleAction;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RoleactionController implements the CRUD actions for RoleAction model.
 */
class RoleactionController extends Controller
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
     * Lists all RoleAction models.
     * @paran int 上级节点id
     * @return mixed
     */
    public function actionIndex($pid = 0)
    {
        $query = RoleAction::find();
        $query = $query->andWhere(['parent_id' => $pid]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        Yii::$app->view->params['meta_title'] = '角色权限节点';

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new RoleAction model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RoleAction();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            Yii::$app->session->setFlash('success', '添加成功');

            return $this->redirect(['index']);
        } else {

            Yii::$app->view->params['meta_title'] = '添加角色节点';

            $actionTop = $model->getActionTop();
            return $this->render('create', [
                'model' => $model,
                'actionTop' => $actionTop
            ]);
        }
    }

    /**
     * Updates an existing RoleAction model.
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

            Yii::$app->view->params['meta_title'] = '修改角色节点';

            $actionTop = $model->getActionTop();
            return $this->render('update', [
                'model' => $model,
                'actionTop' => $actionTop
            ]);
        }
    }

    /**
     * Deletes an existing RoleAction model.
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
     * Finds the RoleAction model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RoleAction the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RoleAction::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
