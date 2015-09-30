<?php

namespace common\models;

use Yii;

class MemberRank extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%member_rank}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rank_name', 'min_points', 'max_points'], 'required'],
            [['rank_name'], 'unique'],
            [['min_points', 'max_points', 'discount', 'show_price', 'special_rank'], 'integer'],
            [['rank_name'], 'string', 'max' => 30],
            [['min_points', 'max_points'], 'checkPoints']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rank_id' => 'Rank ID',
            'rank_name' => '等级名称',
            'min_points' => '积分下限',
            'max_points' => '积分上限',
            'discount' => '初始折扣率(%)',
            'show_price' => '在商品详情页显示该会员等级的商品价格',
            'special_rank' => '特殊会员组',
        ];
    }

    public function checkPoints($attribute, $params){
        if (!$this->hasErrors()) {
            if ($this->special_rank == 0 && $this->min_points >= $this->max_points) {
                $this->addError($attribute, '积分下限需要小于积分上限');
            }
            if ($this->special_rank == 1) {
                $this->min_points = 0;
                $this->max_points = 0;
            }
        }
    }

    /**
     * 获取所有会员等级
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getAll(){
        $list = self::find()->all();
        $arr[0] = '所有等级';

        foreach ($list as $val) {
            $arr[$val['rank_id']] = $val['rank_name'];
        }
        return $arr;
    }

    /**
     * 获取特殊会员等级
     * @return mixed
     */
    public static function getSpecialRank(){
        $list = self::find()->where(['special_rank' => 1])->all();
        $arr[0] = '非特殊等级';

        foreach ($list as $val) {
            $arr[$val['rank_id']] = $val['rank_name'];
        }
        return $arr;
    }

    // 修改详情是否显示价格状态
    public function setShowPrice($rank_id, $status = 1){
        if (!in_array($status, [0, 1])) {
            return false;
        }
        return MemberRank::updateAll(['show_price' => $status], 'rank_id = :rank_id', [':rank_id' => $rank_id]);
    }

    // 修改是否特殊会员组状态
    public function setSpecialRank($rank_id, $status = 1){
        if (!in_array($status, [0, 1])) {
            return false;
        }
        return MemberRank::updateAll(['special_rank' => $status], 'rank_id = :rank_id', [':rank_id' => $rank_id]);
    }

}
