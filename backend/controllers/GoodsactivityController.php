<?php

namespace backend\controllers;

use common\helpers\Functions;
use common\models\Goods;
use common\models\Brand;
use common\models\Category;
use Yii;
use common\models\GoodsActivity;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GoodsactivityController implements the CRUD actions for GoodsActivity model.
 */
class GoodsactivityController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'delgroupbuy' => ['post'],
                ],
            ],
        ];
    }

    /**
     * 团购活动列表
     * @return string
     */
    public function actionGroupbuy(){
        $query = GoodsActivity::find()->where(['act_type' => 1]);

        if (!empty($_GET['goods_name'])) {
            $query = $query->andWhere("goods_name like '%{$_GET['goods_name']}%'");
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'Sort' => [
                'defaultOrder' => [
                    'act_id' => SORT_DESC,
                ]
            ]
        ]);

        Yii::$app->view->params['meta_title'] = '团购活动列表';

        return $this->render('groupbuy', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * 新增团购
     */
    public function actionAddgroupbuy(){
        $model = new GoodsActivity();
        $model->scenario = 'groupbuy';

        if ($model->load(Yii::$app->request->post())) {

            if ($model->validate()) {
                if ($model->addGroupBuy()) {
                    Yii::$app->session->setFlash('success', '添加成功');
                } else {
                    Yii::$app->session->setFlash('error', '添加失败');
                }
            } else {
                $error = Functions::getErrors($model->errors);
                Yii::$app->session->setFlash('error', $error);
            }

            return $this->redirect(['groupbuy']);
        } else {

            Yii::$app->view->params['meta_title'] = '添加团购活动';

            // 品牌
            $Brand = new Brand();
            $brandList = $Brand->dropListHtml();

            // 商品分类
            $Category = new Category();
            $categoryList = $Category->dropListHtml();

            return $this->render('addgroupbuy', [
                'model' => $model,
                'brandList' => $brandList,
                'categoryList' => $categoryList,
                'defaultGoods' => $this->getGoodsOneOption()
            ]);
        }
    }

    /**
     * 修改团购
     */
    public function actionEditgroupbuy($id){
        $model = $this->findModel($id);
        $model->scenario = 'groupbuy';

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->addGroupBuy()) {
                    Yii::$app->session->setFlash('success', '修改成功');
                } else {
                    Yii::$app->session->setFlash('error', '修改失败');
                }
            } else {
                $error = Functions::getErrors($model->errors);
                Yii::$app->session->setFlash('error', $error);
            }

            return $this->redirect(['groupbuy']);
        } else {
            Yii::$app->view->params['meta_title'] = '修改团购活动';

            // 品牌
            $Brand = new Brand();
            $brandList = $Brand->dropListHtml();

            // 商品分类
            $Category = new Category();
            $categoryList = $Category->dropListHtml();

            return $this->render('addgroupbuy', [
                'model' => $model,
                'brandList' => $brandList,
                'categoryList' => $categoryList,
                'defaultGoods' => $this->getGoodsOneOption($model->goods_id)
            ]);
        }
    }

    /**
     * 删除团购活动（待做）
     * @param $id
     * @return \yii\web\Response
     */
    public function actionDelgroupbuy($id){
        return $this->redirect(['groupbuy']);
    }

    /**
     * Lists all GoodsActivity models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => GoodsActivity::find(),
        ]);

        Yii::$app->view->params['meta_title'] = '首页';

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new GoodsActivity model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GoodsActivity();

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
     * Updates an existing GoodsActivity model.
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

            Yii::$app->view->params['meta_title'] = '更新';

            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing GoodsActivity model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
//        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the GoodsActivity model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GoodsActivity the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GoodsActivity::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * 添加、编辑 团购搜索
     */
    public function actionSearchgoods()
    {
        $requert = Yii::$app->request;
        if ($requert->isAjax) {
            $model = new Goods();
            $html = $model->searchGoodsOption($requert->get(), 50);
            echo $html;
        }
    }

    /**
     * 获取一个商品的option
     * @param int $goods_id 商品id
     * @return array
     */
    private function getGoodsOneOption($goods_id = 0){
        if (is_numeric($goods_id) && $goods_id > 0) {
            $goods = Goods::findOne($goods_id);
            $option = [$goods_id => $goods['goods_name']];
        } else {
            $option = ['0' => '请先搜索商品,在此生成选项列表...'];
        }

        return $option;
    }


}
