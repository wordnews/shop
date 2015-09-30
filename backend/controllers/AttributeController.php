<?php

namespace backend\controllers;

use Yii;
use common\models\GoodsType;
use common\models\Attribute;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AttributeController implements the CRUD actions for Attribute model.
 */
class AttributeController extends Controller
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
     * Lists all Attribute models.
     * @return mixed
     */
    public function actionIndex()
    {
        $GoodsType = new GoodsType();

        $query = Attribute::find();

        if (!empty($_GET['cat_id'])) {
            $query->where('cat_id = :cat_id', [':cat_id' => $_GET['cat_id']]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        Yii::$app->view->params['meta_title'] = '商品属性';

        $dropList = $GoodsType->dropList();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'dropList' => $dropList
        ]);
    }

    /**
     * Creates a new Attribute model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Attribute();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            Yii::$app->session->setFlash('success', '添加成功');

            return $this->redirect(['index']);
        } else {
            $GoodsType = new GoodsType();
            $dropList = $GoodsType->dropList(false);

            Yii::$app->view->params['meta_title'] = '添加属性';

            return $this->render('create', [
                'model' => $model,
                'dropList' => $dropList
            ]);
        }
    }

    /**
     * Updates an existing Attribute model.
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
            $GoodsType = new GoodsType();
            $dropList = $GoodsType->dropList(false);

            Yii::$app->view->params['meta_title'] = '编辑属性';

            return $this->render('update', [
                'model' => $model,
                'dropList' => $dropList
            ]);
        }
    }

    /**
     * Deletes an existing Attribute model.
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
     * Finds the Attribute model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Attribute the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Attribute::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * 批量删除
     */
    public function actionDeleteall(){
        if (Yii::$app->request->isPost) {

            $attr_id = $_POST['id'];

            if (is_array($attr_id)) {

                $attr_id = '(' . implode(',', $attr_id) . ')';

                Attribute::deleteAll('attr_id in ' . $attr_id);

                Yii::$app->session->setFlash('success', '删除成功');
            }

        }
        $this->redirect(Yii::$app->request->getReferrer());
    }

    /**
     * 获取一个类型分组 （ 表单页面 ）
     * @param int $cat_id 商品类型id
     * @param int $attr_group_id
     */
    public function actionAttrgroup($cat_id, $attr_group_id = 0){
        $attr_group = GoodsType::findOne($cat_id)->attr_group;
        if (!empty($attr_group)) {
            // 组合成option下拉
            $attr_group = explode("\r\n", $attr_group);

            $option = '';
            foreach ($attr_group as $key => $val) {
                $selected = $attr_group_id == $key ? 'selected' : '';

                $option .= "<option {$selected} value='{$key}'>{$val}</option>";
            }
            exit($option);
        }
    }

}
