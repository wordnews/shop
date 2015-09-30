<?php

namespace common\models;

use Yii;

/**
 * 地区表模型
 */
class Region extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%region}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'region_type', 'agency_id'], 'integer'],
            [['region_name'], 'required'],
            [['region_name'], 'string', 'max' => 120],

            [['parent_id', 'region_type', 'agency_id'], 'default', 'value' => function(){
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
            'region_id' => '地区ID',
            'parent_id' => '上级地区',
            'region_name' => '地区名字',
            'region_type' => '地区级数',
            'agency_id' => '办事处id',
        ];
    }
}
