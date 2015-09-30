<?php

namespace backend\controllers;

use Yii;
use common\models\MemberAccount;
use common\models\Payment;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MemberaccountController implements the CRUD actions for MemberAccount model.
 */
class MemberaccountController extends Controller
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
     * Lists all MemberAccount models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => MemberAccount::find(),
            'Sort' => [
                'defaultOrder' => ['id' => SORT_DESC]
            ]
        ]);

        Yii::$app->view->params['meta_title'] = '充值和提现申请';

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new MemberAccount model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MemberAccount();
        $model->scenario = 'add';

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', '添加成功');
            } else {
                Yii::$app->session->setFlash('error', '添加失败');
            }

            return $this->redirect(['index']);
        } else {

            Yii::$app->view->params['meta_title'] = '添加申请';
            $Payment = new Payment();
            $payment = $Payment->getPayment();

            return $this->render('create', [
                'model' => $model,
                'payment' => $payment
            ]);
        }
    }

    /**
     * Updates an existing MemberAccount model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'edit';

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            unset($model->process_type);
            unset($model->is_paid);

            $model->update_time = time();
            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', '编辑成功');
            } else {
                Yii::$app->session->setFlash('error', '编辑失败');
            }
            return $this->redirect(['index']);
        } else {

            Yii::$app->view->params['meta_title'] = '编辑申请';
            $Payment = new Payment();
            $payment = $Payment->getPayment();

            return $this->render('update', [
                'model' => $model,
                'payment' => $payment
            ]);
        }
    }

    /**
     * 到款审核
     * @param $id
     * @return mixed
     */
    public function actionCheckaccount($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'check';

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->update_time = time();
            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', '操作成功');
            } else {
                Yii::$app->session->setFlash('error', '操作失败');
            }

            return $this->redirect(['index']);
        } else {

            Yii::$app->view->params['meta_title'] = '到款审核';
            $Payment = new Payment();
            $payment = $Payment->getPayment();

            if ($model->errors) {
                dump($model->errors);
                die;
            }

            return $this->render('check', [
                'model' => $model,
                'payment' => $payment
            ]);
        }
    }

    /**
     * Deletes an existing MemberAccount model.
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
     * Finds the MemberAccount model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MemberAccount the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MemberAccount::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
