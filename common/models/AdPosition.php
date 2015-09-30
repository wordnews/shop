<?php

namespace common\models;

use Yii;

class AdPosition extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ad_position}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['position_name', 'ad_width', 'ad_height'], 'required'],
            [['ad_width', 'ad_height'], 'integer'],
            [['position_style'], 'string'],
            [['position_name'], 'string', 'max' => 60],
            [['position_desc'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'position_id' => '广告位置ID',
            'position_name' => '广告位名称',
            'ad_width' => '广告位宽度',
            'ad_height' => '广告位高度',
            'position_desc' => '广告位描述',
            'position_style' => '广告位模板',
        ];
    }

    /**
     * 获取所有广告位置
     */
    public function ad_position(){
        $list = $this->find()->all();

        $result[0] = '站外广告';
        foreach ($list as $val) {
            $result[$val->position_id] = $val->position_name . ' [' . $val->ad_width . 'x' . $val->ad_height . ']';
        }
        return $result;
    }
}
