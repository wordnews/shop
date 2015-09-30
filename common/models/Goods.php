<?php

namespace common\models;

use Yii;

/**
 * 商品模型
 */
class Goods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_id', 'click_count', 'brand_id', 'goods_number', 'warn_number', 'is_real', 'is_on_sale', 'is_alone_sale', 'is_shipping', 'integral', 'add_time', 'sort_order', 'is_delete', 'is_best', 'is_new', 'is_hot', 'is_promote', 'bonus_type_id', 'last_update', 'goods_type', 'give_integral', 'rank_integral', 'suppliers_id', 'is_check'], 'integer'],
            [['goods_name', 'cat_id', 'shop_price'], 'required'],
            [['goods_weight', 'market_price', 'shop_price', 'promote_price'], 'number'],
            [['goods_desc'], 'string'],
            [['goods_sn', 'goods_name_style'], 'string', 'max' => 60],
            [['goods_name'], 'string', 'max' => 120],
            [['provider_name'], 'string', 'max' => 100],
            [['keywords', 'goods_brief', 'goods_thumb', 'goods_img', 'original_img', 'seller_note'], 'string', 'max' => 255],
            [['extension_code'], 'string', 'max' => 30],
            [['goods_img'], 'file', 'extensions' => 'jpg, png, gif, jpeg', 'mimeTypes' => 'image/jpg, image/png, image/gif, image/jpeg'],

            [['brand_id', 'market_price', 'goods_weight'], 'default', 'value' => function(){
                return 0;
            }],
            [['add_time', 'last_update'], 'default', 'value' => function(){
                return $_SERVER['REQUEST_TIME'];
            }],
            [['promote_start_date', 'promote_end_date'], 'filter', 'filter' => function ($value) {
                return strtotime($value);
            }],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'goods_id' => '商品ID',
            'cat_id' => '商品分类',
            'goods_sn' => '商品货号',
            'goods_name' => '商品名称',
            'goods_name_style' => '商品名称显示的样式',
            'click_count' => '商品点击数',
            'brand_id' => '商品品牌',
            'provider_name' => '供货人的名称',
            'goods_number' => '商品库存数量',
            'goods_weight' => '商品重量',
            'market_price' => '市场售价',
            'shop_price' => '本店售价',
            'promote_price' => '促销价',
            'promote_start_date' => '促销开始日期',
            'promote_end_date' => '促销结束日期',
            'warn_number' => '库存警告数量',
            'keywords' => '商品关键词',
            'goods_brief' => '商品简单描述',
            'goods_desc' => '商品详细描述',
            'goods_thumb' => '商品缩略图',
            'goods_img' => '商品图片',
            'original_img' => '商品的原始图片',
            'is_real' => '是否是实物',
            'extension_code' => '商品的扩展属性，比如像虚拟卡',
            'is_on_sale' => '打勾表示允许销售，否则不允许销售',
            'is_alone_sale' => '打勾表示能作为普通商品销售，否则只能作为配件或赠品销售',
            'is_shipping' => '打勾表示此商品不会产生运费花销，否则按照正常运费计算',
            'integral' => '积分购买金额',
            'add_time' => '商品添加时间',
            'sort_order' => '排序',
            'is_delete' => '是否删除',
            'is_best' => '精品',
            'is_new' => '新品',
            'is_hot' => '热销',
            'is_promote' => '是否特价促销',
            'bonus_type_id' => '购买该商品所能领到的红包类型',
            'last_update' => '最近一次更新商品配置的时间',
            'goods_type' => '所属类型',
            'seller_note' => '商家备注',
            'give_integral' => '赠送消费积分数',
            'rank_integral' => '赠送等级积分数',
            'suppliers_id' => '供货商',
            'is_check' => 'Is Check',
        ];
    }

    /**
     * 更新商品的货号
     * @param int $goods_id 商品id
     * @return mixed
     */
    public function editGoodsSn($goods_id)
    {
        $goods_sn = $this->goodsSn($goods_id);

        return Goods::updateAll(['goods_sn' => $goods_sn], ['goods_id' => $goods_id]);
    }

    /**
     * 清空商品的图片
     * @param $goods_id
     * @return int
     */
    public function delImage($goods_id){
        if (!$goods_id) {
            return false;
        }

        $data = [
            'original_img' => '',
            'goods_img' => '',
            'goods_thumb' => ''
        ];
        return self::updateAll($data, ['goods_id' => $goods_id]);
    }

    /**
     * 生成商品货号
     * @param int $goods_id 商品id
     * @return string 商品货号
     */
    public function goodsSn($goods_id)
    {
        return str_repeat('0', 6 - strlen($goods_id)) . $goods_id;
    }

    /**
     * 将一个商品放回到回收站
     * @param int $goods_id 商品的id
     * @param bool $type true:删除，false：还原
     * @return bool
     */
    public function remove($goods_id, $type = true)
    {
        if (($model = self::findOne($goods_id)) !== null) {
            $model->is_delete = $type ? 1 : 0;

            if ($model->save(false)) {
                return true;
            }
        }
        return false;
    }

    /**
     * 查询商品
     * @param array $array 条件数组
     * @param int $limit 需要的条数
     * @return array
     */
    public function searchGoodsAll($array = [], $limit = 50){
        $goods_name = isset($array['goods_name']) ? trim($array['goods_name']) : '';
        $query = self::find()->where(['is_delete' => 0]);

        if (isset($array['cat_id']) && $array['cat_id'] > 0) {
            $query = $query->andWhere(['cat_id' => $array['cat_id']]);
        }
        if (isset($array['brand_id']) && $array['brand_id'] > 0) {
            $query = $query->andWhere(['brand_id' => $array['brand_id']]);
        }
        if (!empty($goods_name)) {
            $query = $query->andWhere("goods_name like '%{$goods_name}%'");
        }
        $list = $query->orderby('goods_id DESC')->limit($limit)->asArray()->all();

        return $list;
    }

    /**
     * 只要option的格式
     *
     * <option value='1'>演示<option/>
     *
     * @param array $array
     * @param int $limit
     * @return string
     */
    public function searchGoodsOption($array = [], $limit = 50){
        $list = $this->searchGoodsAll($array, $limit);

        $html = '';
        foreach ($list as $val) {
            $html .= "<option value='{$val['goods_id']}'>{$val['goods_name']}</option>\n";
        }
        return $html;
    }


    // 修改上下架状态
    public function setOnSale($goods_id, $status = 1){
        if (!in_array($status, [0, 1])) {
            return false;
        }
        return Goods::updateAll(['is_on_sale' => $status], 'goods_id = :goods_id', [':goods_id' => $goods_id]);
    }

    // 修改精品状态
    public function setBest($goods_id, $status = 1){
        if (!in_array($status, [0, 1])) {
            return false;
        }
        return Goods::updateAll(['is_best' => $status], 'goods_id = :goods_id', [':goods_id' => $goods_id]);
    }

    // 修改新品状态
    public function setNew($goods_id, $status = 1){
        if (!in_array($status, [0, 1])) {
            return false;
        }
        return Goods::updateAll(['is_new' => $status], 'goods_id = :goods_id', [':goods_id' => $goods_id]);
    }

    // 修改热销状态
    public function setHot($goods_id, $status = 1){
        if (!in_array($status, [0, 1])) {
            return false;
        }
        return Goods::updateAll(['is_hot' => $status], 'goods_id = :goods_id', [':goods_id' => $goods_id]);
    }


}
