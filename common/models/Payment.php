<?php

namespace common\models;

use Yii;

class Payment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%payment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pay_code', 'pay_desc', 'pay_config'], 'required'],
            [['pay_desc', 'pay_config'], 'string'],
            [['pay_order', 'enabled', 'is_cod', 'is_online'], 'integer'],
            [['pay_code'], 'string', 'max' => 20],
            [['pay_name'], 'string', 'max' => 120],
            [['pay_fee'], 'string', 'max' => 10],
            [['pay_code'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pay_id' => 'Pay ID',
            'pay_code' => '支付方式唯一标识',
            'pay_name' => '支付方式名称',
            'pay_fee' => '支付费用',
            'pay_desc' => '支付方式描述',
            'pay_order' => '支付方式在页面的显示顺序',
            'pay_config' => '支付方式的配置信息，包括商户号和密钥什么的',
            'enabled' => '是否可用，0，否；1，是',
            'is_cod' => '是否货到付款，0，否；1，是',
            'is_online' => '是否在线支付，0，否；1，是',
        ];
    }

    // 获取支付方式 不包括“货到付款”
    public function getPayment(){
        return $this->find()->where("enabled = 1 AND pay_code != 'cod'")->orderBy('pay_id')->all();
    }

}
