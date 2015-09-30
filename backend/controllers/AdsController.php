<?php

namespace backend\controllers;

use Yii;
use common\helpers\File;
use common\models\Ad;
use common\models\AdPosition;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AdsController implements the CRUD actions for Ad model.
 */
class AdsController extends CommonController
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
     * Lists all Ad models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Ad::find(),
            'sort' => [
                'defaultOrder' => ['ad_id' => SORT_DESC]
            ]
        ]);

        Yii::$app->view->params['meta_title'] = '广告列表';

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Ad model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Ad();

        if ($model->load(Yii::$app->request->post())) {

            // 类型为 0：图片；1：Flash时
            if ($model->media_type == 0 || $model->media_type == 1) {
                /* 处理上传的图片 */
                if ($_FILES['Ad']['error']['ad_file'] === 0) {
                    /* 把文件的路劲赋值给image字段 */
                    $model->ad_code = File::uploadImage($model, 'ad_file', 'other');
                }
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', '新增成功');
            }

            return $this->redirect(['index']);
        } else {
            $AdPosition = new AdPosition();

            Yii::$app->view->params['meta_title'] = '添加广告';

            $mediaList = $model->media_type_list();
            $position = $AdPosition->ad_position();

            return $this->render('create', [
                'model' => $model,
                'mediaList' => $mediaList,
                'position' => $position
            ]);
        }
    }

    /**
     * Updates an existing Ad model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            // 类型为 0：图片；1：Flash时
            if ($model->media_type == 0 || $model->media_type == 1) {
                /* 处理上传的图片 */
                if ($_FILES['Ad']['error']['ad_file'] === 0) {
                    /* 把文件的路劲赋值给image字段 */
                    $model->ad_code = File::uploadImage($model, 'ad_file', 'other');
                }
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', '编辑成功');
            }

            return $this->redirect(['index']);
        } else {

            $AdPosition = new AdPosition();

            Yii::$app->view->params['meta_title'] = '编辑广告';

            $mediaList = $model->media_type_list();
            $position = $AdPosition->ad_position();

            return $this->render('update', [
                'model' => $model,
                'mediaList' => $mediaList,
                'position' => $position
            ]);
        }
    }

    /**
     * Deletes an existing Ad model.
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
     * Finds the Ad model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ad the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ad::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionEnabled($ad_id, $status = 1){
        $model = new Ad();
        if ($model->setEnabled($ad_id, $status)) {
            echo '1';
        } else {
            echo '0';
        }
    }

    // 获取对应类型的input框
    public function actionAdhtml($media_type = 0){
        $model = new Ad();
        echo $model->media_type_html($media_type);
    }

}
