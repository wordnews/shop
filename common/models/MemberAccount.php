<?php

namespace common\models;

use Yii;

class MemberAccount extends \yii\db\ActiveRecord
{
    // 类型状态
    public $processTypeStatus = [
        '0' => '充值',
        '1' => '提现'
    ];

    // 到款状态
    public $isPaidStatus = [
        '0' => '未确认',
        '1' => '已完成',
        '2' => '取消'
    ];

    public $user_name; // 会员名称

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%member_account}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'add_time', 'update_time', 'process_type', 'is_paid'], 'integer'],
            [['amount', 'user_name'], 'required', 'on' => ['add', 'edit']],
            [['amount'], 'number'],
            [['admin_user', 'admin_note', 'user_note'], 'string', 'max' => 255],
            [['payment'], 'string', 'max' => 90],
            [['add_time', 'update_time'], 'default', 'value' => function($model, $attribute){
                return time();
            }],
            [['admin_user'], 'default', 'value' => function($model, $attribute){
                return Yii::$app->user->identity->username;
            }],
            [['user_name'], 'checkIsUserName', 'on' => ['add']], // 检查会员是否存在
            [['amount'], 'checkUserMoney', 'on' => ['add', 'check']], // 退款，检查余额是否足够
            [['amount'], 'checkChangeUserMoney', 'on' => ['add', 'check']], // 更新会员余额数量,记录日志

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '会员id',
            'admin_user' => '操作员',
            'amount' => '金额',
            'add_time' => '操作日期',
            'update_time' => '更新日期',
            'admin_note' => '管理员的备注',
            'user_note' => '会员的备注',
            'process_type' => '类型',
            'payment' => '支付方式',
            'is_paid' => '到款状态',
            'user_name' => '会员名称'
        ];
    }



    // 检查会员是否存在 同时设定user_id
    public function checkIsUserName($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $post = Yii::$app->request->post('MemberAccount');
            $member = Member::findOne(['user_name' => $post['user_name']]);
            if ($member) {
                $this->user_id = $member->user_id;
            } else {
                $this->addError($attribute, '您输入的会员名称不存在');
            }
        }
    }

    // 退款(提现)，检查余额是否足够
    public function checkUserMoney($attribute, $params)
    {
        if ($this->process_type == 1) {
            $user_money = Member::findOne($this->user_id)->user_money;

            if ($this->amount > $user_money) {
                $this->addError($attribute, '要提现的金额超过了此会员的帐户余额，此操作将不可进行！');
            }
        }
    }

    // 更新会员余额数量,记录日志
    public function checkChangeUserMoney($attribute, $params)
    {
        // 信息正确，且到款状态为完成
        if (!$this->hasErrors() && $this->is_paid == 1) {
            if ($this->process_type == 1) { // 提现
                $money = -1 * $this->amount;
                $type = 1; // 提现
                $change_desc = '提现';
            } else {
                $money = $this->amount;
                $type = 0; // 充值
                $change_desc = '充值';
            }

            $AccountLog = new AccountLog();
            $AccountLog->log_account_change($this->user_id, $money, 0, 0, 0, $change_desc, $type);
        }
    }

}
