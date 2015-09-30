<?php

namespace common\models;

use Yii;
use common\helpers\Images;

/**
 * 商品相册模型
 */
class GoodsGallery extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods_gallery}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id'], 'integer'],
            [['img_desc', 'thumb_url', 'img_original'], 'string', 'max' => 255],
            [['img_url'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, png, gif, jpeg', 'maxFiles' => 6],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'img_id' => 'Img ID',
            'goods_id' => 'Goods ID',
            'img_url' => '商品相册',
            'img_desc' => 'Img Desc',
            'thumb_url' => 'Thumb Url',
            'img_original' => 'Img Original',
        ];
    }

    /**
     * 新增商品相册
     * @param int $goods_id 商品id
     * @param array $imgs 图片路径数组
     */
    public function addData($goods_id, $imgs){
        $sql = "INSERT INTO {{%goods_gallery}} (`goods_id`, `img_url`, `thumb_url`) VALUES ";

        foreach ($imgs as $val) {
            $thumb_url = Images::thumb('./' . $val, 180, 180);

            $sql .= "({$goods_id}, '{$val}', '{$thumb_url}'),";
        }

        Yii::$app->db->createCommand(trim($sql, ','))->execute();
    }

    /**
     * 商品的相册列表
     * @param $goods_id
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getGoodsGallery($goods_id){
        return $this->find()->where(['goods_id' => $goods_id])->all();
    }

    /**
     * 删除商品的一张相册图片
     * @param $img_id
     * @return bool
     * @throws \Exception
     */
    public function delGoodsGallery($img_id){
        if (($model = self::findOne($img_id)) !== null) {
            if ($model->delete()) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

}
