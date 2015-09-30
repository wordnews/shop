<?php

namespace common\models;

use Yii;

/**
 * 拍卖活动和夺宝奇兵活动配置信息模型
 *
 * Class GoodsActivity
 * @package common\models
 */
class GoodsActivity extends \yii\db\ActiveRecord
{
    /**
     * 团购状态
     * @var array
     */
    public $groupbuyStatus = [
        '0' => '未处理',
        '3' => '成功结束',
        '4' => '失败结束'
    ];

    public $deposit; // 保证金
    public $restrict_amount; // 限购数量
    public $gift_integral; // 赠送积分数
    public $ladder_amount; // 优惠数量
    public $ladder_price; // 优惠价格
    public $price_ladder; // 阶梯价格信息

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods_activity}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id', 'start_time', 'end_time'], 'required'],
            [['act_type', 'goods_id', 'product_id', 'is_finished', 'deposit', 'restrict_amount', 'gift_integral'], 'integer'],
            [['act_name', 'goods_name'], 'string', 'max' => 255],
            [['goods_id'], 'compare', 'compareValue' => 0, 'operator' => '>', 'message' => '请选择商品', 'on' => ['groupbuy']],
            [['start_time', 'end_time'], 'filter', 'filter' => 'strtotime'],

            [['start_time', 'end_time'], 'checkDateTime'], // 开始时间不能大于结束时间
            ['ladder_amount', 'handleLadderAmount'], // 处理阶梯价格
            ['restrict_amount', 'chackRestrictAmount'], // 限购数量不能小于价格阶梯中的最大数量
            ['goods_id', 'checkIsGoodsGroupBuy', 'on' => ['groupbuy']] // 检查当前商品是否有参加团购活动
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'act_id' => 'ID',
            'act_name' => '促销活动的名称',
            'act_desc' => '促销活动的描述',
            'act_type' => '活动类型 0：夺宝奇兵，1：团购，2：拍卖，4：超值礼包',
            'goods_id' => '商品',
            'product_id' => '商品的货号id',
            'goods_name' => '商品名称',
            'start_time' => '活动开始时间',
            'end_time' => '活动结束时间',
            'is_finished' => '状态',
            'ext_info' => '序列化后的促销活动的配置信息，包括最低价，最高价，出价幅度，保证金等',
            'deposit' => '保证金',
            'restrict_amount' => '限购数量',
            'gift_integral' => '赠送积分数',
            'ladder_amount' => '数量达到',
            'ladder_price' => '享受价格'
        ];
    }

    /**
     * 新增团购活动
     * @return bool
     */
    public function addGroupBuy(){
        $post = Yii::$app->request->post('GoodsActivity');

        $goods = Goods::findOne($this->goods_id);

        $this->act_name = $goods['goods_name'];
        $this->goods_name = $goods['goods_name'];
        $this->act_type = 1;

        $ext_info = [
            'price_ladder' => $this->price_ladder,
            'restrict_amount' => intval($post['restrict_amount']),
            'gift_integral' => intval($post['gift_integral']),
            'deposit' => floatval($post['deposit']),
        ];

        $this->ext_info = serialize($ext_info);

        if ($this->save(false)) {
            return true;
        } else {
            return false;
        }
    }

    // 开始时间不能大于结束时间
    public function checkDateTime($attribute, $params){
        if (!$this->hasErrors()) {
            if ($this->start_time >= $this->end_time) {
                $this->addError($attribute, '您输入了一个无效的团购时间。');
            }
        }
    }

    // 处理阶梯价格
    public function handleLadderAmount($attribute, $params){
        if (!$this->hasErrors()) {
            $post = Yii::$app->request->post('GoodsActivity');

            $price_ladder = [];
            // 处理阶梯价格
            $count = count($post['ladder_amount']);
            for ($i = $count - 1; $i >= 0; $i--)
            {
                /* 如果数量小于等于0，不要 */
                $amount = intval($post['ladder_amount'][$i]);
                if ($amount <= 0) {
                    continue;
                }
                /* 如果价格小于等于0，不要 */
                $price = round(floatval($post['ladder_price'][$i]), 2);
                if ($price <= 0) {
                    continue;
                }
                /* 加入价格阶梯 */
                $price_ladder[$amount] = array('amount' => $amount, 'price' => $price);
            }
            if (count($price_ladder) < 1) {
                $this->addError($attribute, '您没有输入有效的价格阶梯！');
            }
            $this->price_ladder = $price_ladder;
        }
    }

    // 限购数量不能小于价格阶梯中的最大数量
    public function chackRestrictAmount($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $post = Yii::$app->request->post('GoodsActivity');

            $restrict_amount = intval($post['restrict_amount']);
            $amount_list = array_keys($this->price_ladder);
            if ($restrict_amount > 0 && max($amount_list) > $restrict_amount) {
                $this->addError($attribute, '限购数量不能小于价格阶梯中的最大数量');

                ksort($this->price_ladder);
                $this->price_ladder = array_values($this->price_ladder);
            }
        }
    }

    // 检查商品是否在进行一个团购活动
    public function checkIsGoodsGroupBuy($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if ($this->checkGoodsGroupBuy($this->goods_id, $this->act_id)) {
                $this->addError($attribute, '您选择的商品目前有一个团购活动正在进行！');
            }
        }
    }

    /**
     * 检查一个商品是否在参加活动
     * @param $goods_id
     * @param int $act_id 活动id
     * @return bool
     */
    public function checkGoodsGroupBuy($goods_id, $act_id = 0)
    {
        $goods = GoodsActivity::find()->where(['goods_id' => $goods_id])
            ->andWhere(['act_type' => '1'])
            ->andWhere(['<=', 'start_time', time()])
            ->andWhere(['>=', 'end_time', time()])
            ->one();
        if ($goods && $goods['act_id'] != $act_id) {
            return true; // 在参加活动
        } else {
            return false; // 没有
        }
    }

    /**
     * 获取团购状态
     * @param mixed $model 团购模型
     * @return string
     */
    public function groupBuyStatus($model)
    {
        if ($model['is_finished'] == 0) {
            $now = time();
            /* 未处理 */
            if ($now < $model['start_time']) {
                $status = '未开始';
            } elseif ($now > $model['end_time']) {
                $status = '结束未处理';
            } else {
                if ($model['restrict_amount'] == 0 || $model['valid_goods'] < $model['restrict_amount']) {
                    $status = '进行中';
                } else {
                    $status = '结束未处理';
                }
            }
        } elseif ($model['is_finished'] == 3) {
            /* 已处理，团购成功 */
            $status = '成功结束';
        } elseif ($model['is_finished'] == 4) {
            /* 已处理，团购失败 */
            $status = '失败结束';
        }

        return $status;
    }

}
