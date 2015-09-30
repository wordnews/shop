<?php

namespace backend\controllers;

use common\models\Attribute;
use common\models\GoodsAttr;
use common\models\GoodsType;
use common\models\Brand;
use common\models\Category;
use common\models\GoodsGallery;
use Yii;
use common\models\Goods;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\helpers\File;
use common\helpers\Images;

/**
 * GoodsController implements the CRUD actions for Goods model.
 */
class GoodsController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'remove' => ['post'],
                    'restore' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Goods models.
     * @return mixed
     */
    public function actionIndex()
    {
        $query = Goods::find()->where(['is_delete' => 0]);

        /* 搜索 begin */
        if ($_GET['cat_id'] > 0) {
            $query = $query->andWhere(['cat_id' => $_GET['cat_id']]);
        }
        if ($_GET['brand_id'] > 0) {
            $query = $query->andWhere(['brand_id' => $_GET['brand_id']]);
        }
        if ($_GET['intro_type'] && $_GET['intro_type'] != 'is_all') {
            $query = $query->andWhere([$_GET['intro_type'] => 1]);
        }
        if (is_numeric($_GET['is_on_sale'])) {
            $query = $query->andWhere(['is_on_sale' => $_GET['is_on_sale']]);
        }
        if (!empty($_GET['goods_name'])) {
            $query = $query->andWhere("goods_name like '%{$_GET['goods_name']}%'");
        }
        /* 搜索 end */

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'Sort' => [
                'defaultOrder' => [
                    'goods_id' => SORT_DESC,
                ]
            ]
        ]);

        Yii::$app->view->params['meta_title'] = '商品列表';

        // 商品分类
        $Category = new Category();
        $categoryList = $Category->dropListHtml();

        // 品牌
        $Brand = new Brand();
        $brandList = $Brand->dropListHtml();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'categoryList' => $categoryList,
            'brandList' => $brandList
        ]);
    }

    /**
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Goods();
        $GoodsGallery = new GoodsGallery();

        $post = Yii::$app->request->post();

        if ($model->load($post)) {
            $GoodsGallery->load($post);

            if ($model->validate() && $GoodsGallery->validate()) {

                // 商品封面图片
                if ($_FILES['Goods']['error']['goods_img'] === 0) {
                    $model->goods_img = File::uploadImage($model, 'goods_img', 'shop');
                    $model->goods_thumb = Images::thumb('./' . $model->goods_img, 250, 250);
                }
                if ($model->save(false)) {
                    // 更新商品货号
                    $model->editGoodsSn($model->goods_id);

                    // 商品相册
                    if ($_FILES['GoodsGallery']['error']['img_url'][0] === 0) {
                        $img_url = File::uploadImages($GoodsGallery, 'img_url', 'goods');
                        $GoodsGallery->addData($model->goods_id, $img_url);
                    }

                    // 商品属性
                    GoodsAttr::addData($model->goods_id);
                }

                Yii::$app->session->setFlash('success', '添加成功');
            }

            return $this->redirect(['index']);
        } else {

            // 商品分类
            $Category = new Category();
            $categoryList = $Category->parent(0, false);

            // 品牌
            $Brand = new Brand();
            $brandList = $Brand->getLists();

            // 商品类型
            $GoodsType = new GoodsType();
            $goodsTypeList = $GoodsType->dropList();

            Yii::$app->view->params['meta_title'] = '添加新商品';

            return $this->render('create', [
                'model' => $model,
                'GoodsGallery' => $GoodsGallery,
                'categoryList' => $categoryList,
                'brandList' => $brandList,
                'goodsTypeList' => $goodsTypeList
            ]);
        }
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $GoodsGallery = new GoodsGallery();

        $post = Yii::$app->request->post();

        if ($model->load($post)) {
            $GoodsGallery->load($post);

            if ($model->validate() && $GoodsGallery->validate()) {

                // 商品封面图片
                if ($_FILES['Goods']['error']['goods_img'] === 0) {
                    $model->goods_img = File::uploadImage($model, 'goods_img', 'shop');
                    $model->goods_thumb = Images::thumb('./' . $model->goods_img, 250, 250);
                }
                if ($model->save(false)) {

                    // 商品相册
                    if ($_FILES['GoodsGallery']['error']['img_url'][0] === 0) {
                        $img_url = File::uploadImages($GoodsGallery, 'img_url', 'goods');
                        $GoodsGallery->addData($model->goods_id, $img_url);
                    }

                    // 商品属性
                    GoodsAttr::addData($model->goods_id);
                }

                Yii::$app->session->setFlash('success', '编辑成功');
            }

            return $this->redirect(['index']);
        } else {

            // 商品分类
            $Category = new Category();
            $categoryList = $Category->parent(0, false);

            // 品牌
            $Brand = new Brand();
            $brandList = $Brand->getLists();

            // 商品类型
            $GoodsType = new GoodsType();
            $goodsTypeList = $GoodsType->dropList();

            // 相册
            $goodsGalleryList = $GoodsGallery->getGoodsGallery($id);

            Yii::$app->view->params['meta_title'] = '编辑商品';

            return $this->render('update', [
                'model' => $model,
                'GoodsGallery' => $GoodsGallery,
                'categoryList' => $categoryList,
                'brandList' => $brandList,
                'goodsTypeList' => $goodsTypeList,
                'goodsGalleryList' => $goodsGalleryList
            ]);
        }
    }

    /**
     * 回收站列表
     */
    public function actionTrash(){
        $query = Goods::find()->where(['is_delete' => 1]);

        if (!empty($_GET['goods_name'])) {
            $query = $query->andWhere("goods_name like '%{$_GET['goods_name']}%'");
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'Sort' => [
                'defaultOrder' => [
                    'goods_id' => SORT_DESC,
                ]
            ]
        ]);

        Yii::$app->view->params['meta_title'] = '商品回收站';

        return $this->render('trash', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * 放入到回收站
     * @param $id
     */
    public function actionRemove($id)
    {
        $model = new Goods();
        if ($model->remove($id, true)) {
            Yii::$app->session->setFlash('success', '放入回收站成功');
        }
        $this->redirect(['index']);
    }

    /**
     * 还原一个商品
     * @param $id
     */
    public function actionRestore($id){
        $model = new Goods();
        if ($model->remove($id, false)) {
            Yii::$app->session->setFlash('success', '还原成功');
        }
        $this->redirect(['trash']);
    }

    /**
     * Deletes an existing Goods model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if ($this->findModel($id)->delete()) {
            // 删除相册
            GoodsGallery::deleteAll(['goods_id' => $id]);

            // 删除属性
            GoodsAttr::deleteAll(['goods_id' => $id]);
            Yii::$app->session->setFlash('success', '删除成功');
        }
        return $this->redirect(['remove']);
    }

    /**
     * Finds the Goods model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Goods the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Goods::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * 获取商品类型的属性表单
     * @param int $cat_id 商品类型id
     * @param int $goods_id
     */
    public function actionGetattribute($cat_id, $goods_id = 0)
    {
        $Attribute = new Attribute();

        echo $Attribute->attributeHtml($cat_id, $goods_id);
    }

    /**
     * 删除商品的图片
     * @param $goods_id
     */
    public function actionDelimage($goods_id){
        if (Yii::$app->request->isAjax) {
            $model = new Goods();

            if ($model->delImage($goods_id)) {
                echo '1';
            } else {
                echo '0';
            }
        }
    }

    /**
     * 删除商品的一张相册图片
     * @param $img_id
     */
    public function actionDelgallery($img_id){
        if (Yii::$app->request->isAjax) {
            $model = new GoodsGallery();

            if ($model->delGoodsGallery($img_id)) {
                echo '1';
            } else {
                echo '0';
            }
        }
    }

    // 修改上下架状态
    public function actionSale($goods_id, $status = 1)
    {
        $model = new Goods();

        if ($model->setOnSale($goods_id, $status)) {
            echo '1';
        } else {
            echo '0';
        }
    }

    // 修改精品状态
    public function actionBest($goods_id, $status = 1)
    {
        $model = new Goods();

        if ($model->setBest($goods_id, $status)) {
            echo '1';
        } else {
            echo '0';
        }
    }

    // 修改精品状态
    public function actionNew($goods_id, $status = 1)
    {
        $model = new Goods();

        if ($model->setNew($goods_id, $status)) {
            echo '1';
        } else {
            echo '0';
        }
    }

    // 修改热销状态
    public function actionHot($goods_id, $status = 1)
    {
        $model = new Goods();

        if ($model->setHot($goods_id, $status)) {
            echo '1';
        } else {
            echo '0';
        }
    }

}
