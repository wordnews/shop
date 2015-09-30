<?php

namespace backend\controllers;

use Yii;
use common\models\Member;
use common\models\MemberRank;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MemberController implements the CRUD actions for Member model.
 */
class MemberController extends Controller
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
     * Lists all Member models.
     * @return mixed
     */
    public function actionIndex()
    {
        $requert = Yii::$app->request;
        $user_name = $requert->get('user_name');
        $min_points = intval($requert->get('min_points'));
        $mix_points = intval($requert->get('mix_points'));
        $query = Member::find();

        if (!empty($user_name)) {
            $query = $query->andWhere("user_name like '%{$user_name}%'");
        }
        if ($min_points > 0 && $mix_points > 0) {
            $query = $query->andWhere("rank_points between {$min_points} and {$mix_points}");
        } elseif($min_points > 0) {
            $query = $query->andWhere(['>=', 'rank_points', $min_points]);
        } elseif($mix_points > 0) {
            $query = $query->andWhere(['<=', 'rank_points', $min_points]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'Sort' => [
                'defaultOrder' => ['user_id' => SORT_DESC]
            ]
        ]);

        Yii::$app->view->params['meta_title'] = '会员列表';
        // 会员等级列表
        $memberRank = MemberRank::getAll();
        
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'memberRank' => $memberRank
        ]);
    }

    /**
     * Creates a new Member model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Member();
        $model->scenario = 'add';

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->addData()) {
                    Yii::$app->session->setFlash('success', '添加成功');
                } else {
                    Yii::$app->session->setFlash('error', '添加失败');
                }
            } else {
                $error = \common\helpers\Functions::getErrors($model->errors);
                Yii::$app->session->setFlash('error', $error);
            }

            return $this->redirect(['index']);
        } else {

            Yii::$app->view->params['meta_title'] = '添加会员';
            // 获取特殊会员等级
            $SpecialRank = MemberRank::getSpecialRank();

            return $this->render('create', [
                'model' => $model,
                'SpecialRank' => $SpecialRank
            ]);
        }
    }

    /**
     * Updates an existing Member model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->editData()) {
                    Yii::$app->session->setFlash('success', '编辑成功');
                } else {
                    Yii::$app->session->setFlash('error', '编辑失败');
                }
            } else {
                $error = \common\helpers\Functions::getErrors($model->errors);
                Yii::$app->session->setFlash('error', $error);
            }

            return $this->redirect(['index']);
        } else {

            Yii::$app->view->params['meta_title'] = '编辑会员';
            // 获取特殊会员等级
            $SpecialRank = MemberRank::getSpecialRank();

            return $this->render('update', [
                'model' => $model,
                'SpecialRank' => $SpecialRank
            ]);
        }
    }

    /**
     * Deletes an existing Member model.
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
     * Finds the Member model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Member the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Member::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
