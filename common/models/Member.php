<?php

namespace common\models;

use Yii;

/**
 * 会员表模型
 */
class Member extends \yii\db\ActiveRecord
{
    public $repassword; // 确认密码
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%member}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_name', 'email'], 'required'],
            [['password', 'repassword'], 'required', 'on' => ['add']],
            [['sex', 'pay_points', 'rank_points', 'address_id', 'reg_time', 'last_login', 'visit_count', 'user_rank', 'is_special', 'parent_id', 'flag', 'is_validated', 'qq', 'mobile_phone'], 'integer'],
            [['birthday', 'last_time'], 'safe'],
            [['user_money', 'frozen_money', 'credit_line'], 'number'],
            [['email', 'user_name', 'alias', 'msn'], 'string', 'max' => 60],
            [['auth_key'], 'string', 'max' => 32],
            [['password'], 'string', 'max' => 80],
            [['question', 'answer', 'passwd_answer'], 'string', 'max' => 255],
            [['last_ip'], 'string', 'max' => 15],
            [['ec_salt', 'salt'], 'string', 'max' => 10],
            [['qq', 'home_phone', 'mobile_phone'], 'string', 'max' => 20],
            [['passwd_question'], 'string', 'max' => 50],
            [['user_name', 'email'], 'unique'],
            [['user_name'], 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            [['user_name'], 'string', 'min' => 3],
            [['password'], 'string', 'min' => 6],
            ['repassword', 'compare', 'compareAttribute' => 'password', 'message' => '确认密码与密码不一致'],
            [['reg_time'], 'default', 'value' => function($model, $attribute){
                return time();
            }],

            [['sex'], 'default', 'value' => function(){
                return 0;
            }],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'Id',
            'email' => '会员邮箱',
            'user_name' => '会员名称',
            'password' => '登陆密码',
            'repassword' => '确认密码',
            'question' => '安全问题答案',
            'answer' => '安全问题',
            'sex' => '性别',
            'birthday' => '出生日期',
            'user_money' => '可用资金',
            'frozen_money' => '冻结资金',
            'pay_points' => '消费积分',
            'rank_points' => '等级积分',
            'address_id' => '收货信息id，取值表 ecs_user_address',
            'reg_time' => '注册时间',
            'last_login' => '最后一次登录时间',
            'last_time' => '应该是最后一次修改信息时间，该表信息从其他表同步过来考虑',
            'last_ip' => '最后一次登录ip',
            'visit_count' => '登录次数',
            'user_rank' => '会员等级',
            'is_special' => 'Is Special',
            'ec_salt' => 'Ec Salt',
            'salt' => 'Salt',
            'parent_id' => '推荐人会员id',
            'flag' => 'Flag',
            'alias' => '昵称',
            'msn' => 'MSN',
            'qq' => 'QQ号',
            'home_phone' => '家庭电话',
            'mobile_phone' => '手机',
            'is_validated' => 'Is Validated',
            'credit_line' => '信用额度',
            'passwd_question' => '密码找回问题',
            'passwd_answer' => '密码找回答案',
            'auth_key' => '认证key',
        ];
    }

    /**
     * 新增会员
     * @return bool
     */
    public function addData(){
        $User = new User();

        $this->password = $User->setPasswordShop($this->password);
        $this->auth_key = $User->generateAuthKeyShop();

        if ($this->save(false)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 编辑会员
     * @return bool
     */
    public function editData(){
        if ($this->password && strlen($this->password) > 5) {
            $User = new User();
            $this->password = $User->setPasswordShop($this->password);
        } else {
            unset($this->password);
        }
        if ($this->save(false)) {
            return true;
        } else {
            return false;
        }
    }


}
