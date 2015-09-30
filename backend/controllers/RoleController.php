<?php

namespace backend\controllers;

use common\models\Menu;
use common\models\RoleAction;
use Yii;
use common\models\Role;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RoleController implements the CRUD actions for Role model.
 */
class RoleController extends Controller
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
     * Lists all Role models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Role::find(),
        ]);

        Yii::$app->view->params['meta_title'] = '角色管理';

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Role model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Role();

        if ($model->load(Yii::$app->request->post()) && $model->addData()) {

            Yii::$app->session->setFlash('success', '添加成功');

            return $this->redirect(['index']);
        } else {

            Yii::$app->view->params['meta_title'] = '添加角色';

            // 菜单
            $Menu = new Menu();
            $treeMenuList = $Menu->treeList();
            // 权限节点
            $RoleAction = new RoleAction();
            $treeRoleList = $RoleAction->treeList();

            return $this->render('create', [
                'model' => $model,
                'treeMenuList' => $treeMenuList,
                'treeRoleList' => $treeRoleList
            ]);
        }
    }

    /**
     * Updates an existing Role model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->addData()) {

            Yii::$app->session->setFlash('success', '编辑成功');

            return $this->redirect(['index']);
        } else {

            Yii::$app->view->params['meta_title'] = '编辑角色';

            // 菜单
            $Menu = new Menu();
            $treeMenuList = $Menu->treeList();
            // 权限节点
            $RoleAction = new RoleAction();
            $treeRoleList = $RoleAction->treeList();

            return $this->render('update', [
                'model' => $model,
                'treeMenuList' => $treeMenuList,
                'treeRoleList' => $treeRoleList
            ]);
        }
    }

    /**
     * Deletes an existing Role model.
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
     * Finds the Role model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Role the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Role::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
