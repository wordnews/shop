<?php

namespace common\models;

use Yii;

class AccountLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'user_money', 'frozen_money', 'rank_points', 'pay_points', 'change_time', 'change_desc', 'change_type'], 'required'],
            [['user_id', 'rank_points', 'pay_points', 'change_time', 'change_type'], 'integer'],
            [['user_money', 'frozen_money'], 'number'],
            [['change_desc'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'log_id' => 'Log ID',
            'user_id' => '会员id',
            'user_money' => '用户该笔记录的余额',
            'frozen_money' => '被冻结的资金',
            'rank_points' => '等级积分',
            'pay_points' => '消费积分',
            'change_time' => '该笔操作发生的时间',
            'change_desc' => '备注',
            'change_type' => '操作类型，0为充值，1为提现，2为管理员调节，99为其他类型',
        ];
    }

    /**
     * 记录帐户变动
     * @param   int     $user_id        用户id
     * @param   float   $user_money     可用余额变动
     * @param   float   $frozen_money   冻结余额变动
     * @param   int     $rank_points    等级积分变动
     * @param   int     $pay_points     消费积分变动
     * @param   string  $change_desc    变动说明
     * @param   int     $change_type    变动类型
     * @return  void
     */
    public function log_account_change($user_id, $user_money = 0, $frozen_money = 0, $rank_points = 0, $pay_points = 0, $change_desc = '', $change_type = 99)
    {
        /* 记录资金变动信息 */
        $this->user_id = $user_id;
        $this->user_money = $user_money;
        $this->frozen_money = $frozen_money;
        $this->rank_points = $rank_points;
        $this->pay_points = $pay_points;
        $this->change_time = time();
        $this->change_desc = $change_desc;
        $this->change_type = $change_type;
        $this->save(false);

        /* 更新用户信息 */
        $Member = Member::findOne($user_id);
        $Member->user_money += $user_money;
        $Member->frozen_money += $frozen_money;
        $Member->rank_points += $rank_points;
        $Member->pay_points += $pay_points;
        $Member->save(false);
    }
    
}
