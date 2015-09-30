<?php

namespace common\models;

use Yii;

/**
 * 商品类型
 */
class GoodsType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods_type}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_name'], 'required'],
            [['cat_name'], 'unique'],
            [['enabled'], 'integer'],
            [['cat_name'], 'string', 'max' => 60],
            [['attr_group'], 'string', 'max' => 255],

            [['enabled'], 'default', 'value' => function () {
                return 1;
            }]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cat_id' => '类型ID',
            'cat_name' => '商品类型名称',
            'enabled' => '状态',
            'attr_group' => '属性分组',
        ];
    }

    /**
     * 修改状态
     * @param $cat_id
     * @param int $status
     * @return bool|int
     */
    public function setEnabled($cat_id, $status = 1){
        if (!in_array($status, [0, 1])) {
            return false;
        }
        return GoodsType::updateAll(['enabled' => $status], 'cat_id = :cat_id', [':cat_id' => $cat_id]);
    }

    /**
     * 商品属性 - 首页搜索框需要的格式
     * @param bool $default
     * @return mixed
     */
    public function dropList($default = true){
        $list = $this->find()->where(['enabled' => 1])->all();

        if ($default) {
            $result[0] = '所有商品属性';
        } else {
            $result = [];
        }

        foreach ($list as $val) {
            $result[$val->cat_id] = $val->cat_name;
        }

        return $result;
    }


}
