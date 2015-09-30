<?php

namespace backend\controllers;

use Yii;
use common\models\MemberRank;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MemberrankController implements the CRUD actions for MemberRank model.
 */
class MemberrankController extends Controller
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
     * Lists all MemberRank models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => MemberRank::find(),
            'Sort' => [
                'defaultOrder' => ['rank_id' => SORT_DESC]
            ]
        ]);

        Yii::$app->view->params['meta_title'] = '会员等级';

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new MemberRank model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MemberRank();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            Yii::$app->session->setFlash('success', '添加成功');

            return $this->redirect(['index']);
        } else {

            Yii::$app->view->params['meta_title'] = '添加会员等级';

            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MemberRank model.
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

            Yii::$app->view->params['meta_title'] = '修改会员等级';

            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing MemberRank model.
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
     * Finds the MemberRank model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MemberRank the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MemberRank::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionShowprice($rank_id, $status = 1){
        $model = new MemberRank();
        if ($model->setShowPrice($rank_id, $status)) {
            echo '1';
        } else {
            echo '0';
        }
    }

    public function actionSpecialrank($rank_id, $status = 1){
        $model = new MemberRank();
        if ($model->setSpecialRank($rank_id, $status)) {
            echo '1';
        } else {
            echo '0';
        }
    }

}
