<?php

namespace common\models;

use Yii;

/**
 * 商店配置
 */
class ShopConfig extends \yii\db\ActiveRecord
{
    public $shop_name;
    public $shop_title;
    public $shop_desc;
    public $shop_keywords;
    public $shop_address;
    public $qq;
    public $ww;
    public $service_email;
    public $service_phone;
    public $shop_closed;
    public $close_comment;
    public $user_notice;
    public $shop_notice;
    public $shop_reg_closed;

    public $comment_check;
    public $stats_code;
    public $register_points;
    public $enable_order_check;
    public $visit_stats;
    public $message_board;
    public $member_email_validate;
    public $send_verify_email;
    public $message_check;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_config}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'sort_order'], 'integer'],
            [['name', 'code'], 'required'],
            [['value'], 'string'],
            [['name', 'code'], 'string', 'max' => 30],
            [['desc'], 'string', 'max' => 200],
            [['type'], 'string', 'max' => 10],
            [['store_range', 'store_dir'], 'string', 'max' => 255],
            [['code'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            /*'id' => '配置ID',
            'parent_id' => '所属分组',
            'name' => '配置名称',
            'code' => '配置标识',
            'desc' => '配置描述',
            'type' => 'Type',
            'store_range' => 'Store Range',
            'store_dir' => 'Store Dir',
            'value' => '配置的值',
            'sort_order' => '排序',*/

            // 商店信息设置
            'shop_name' => '商店名称',
            'shop_title' => '商店标题',
            'shop_desc' => '商店描述',
            'shop_keywords' => '商店关键字',
            'shop_address' => '详细地址',
            'qq' => '客服QQ号码',
            'ww' => '淘宝旺旺',
            'service_email' => '客服邮件地址',
            'service_phone' => '客服电话',
            'shop_closed' => '暂时关闭网站',
            'close_comment' => '关闭网店的原因',
            'user_notice' => '用户中心公告',
            'shop_notice' => '商店公告',
            'shop_reg_closed' => '是否关闭注册',

            // 基本设置
            'stats_code' => '统计代码',
            'register_points' => '会员注册赠送积分',
            'comment_check' => '用户评论是否需要审核',
            'enable_order_check' => '是否开启新订单提醒',
            'visit_stats' => '站点访问统计',
            'message_board' => '是否启用留言板功能',
            'member_email_validate' => '是否开启会员邮件验证',
            'send_verify_email' => '用户注册时自动发送验证邮件',
            'message_check' => '用户留言是否需要审核'
        ];
    }

    /**
     * 编辑配置
     * @param array $data $_POST数组
     * @return bool
     */
    public function editData($data){
        if (is_array($data)) {

            foreach ($data as $key => $val) {
                self::updateAll(['value' => $val], "code = '{$key}'");
            }
            return true;
        }
        return false;
    }

    /**
     * 给配置项赋值
     */
    public function setData(){
        $list = $this->find()->all();

        $data = [];
        foreach ($list as $val) {
            $data[$val->code] = $val->value;
        }

        $this->shop_name = $data['shop_name'];
        $this->shop_title = $data['shop_title'];
        $this->shop_desc = $data['shop_desc'];
        $this->shop_keywords = $data['shop_keywords'];
        $this->shop_address = $data['shop_address'];
        $this->qq = $data['qq'];
        $this->ww = $data['ww'];
        $this->service_email = $data['service_email'];
        $this->service_phone = $data['service_phone'];
        $this->shop_closed = $data['shop_closed'];
        $this->close_comment = $data['close_comment'];
        $this->user_notice = $data['user_notice'];
        $this->shop_notice = $data['shop_notice'];
        $this->shop_reg_closed = $data['shop_reg_closed'];
        $this->stats_code = $data['stats_code'];
        $this->register_points = $data['register_points'];
        $this->comment_check = $data['comment_check'];
        $this->enable_order_check = $data['enable_order_check'];
        $this->visit_stats = $data['visit_stats'];
        $this->message_board = $data['message_board'];
        $this->member_email_validate = $data['member_email_validate'];
        $this->send_verify_email = $data['send_verify_email'];
        $this->message_check = $data['message_check'];

    }
    
}
