<?php

namespace common\models;

use Yii;

/**
 * 具体商品属性模型
 */
class GoodsAttr extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods_attr}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id', 'attr_id'], 'integer'],
            [['attr_value'], 'required'],
            [['attr_value'], 'string'],
            [['attr_price'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'goods_attr_id' => 'Goods Attr ID',
            'goods_id' => 'Goods ID',
            'attr_id' => 'Attr ID',
            'attr_value' => 'Attr Value',
            'attr_price' => 'Attr Price',
        ];
    }

    public static function addData($goods_id)
    {
        if (isset($_POST['attr_id_list']) && isset($_POST['attr_value_list'])) {

            /*$attr_list = [];

            $attr_res = Attribute::find()->select(['attr_id', 'attr_index'])->where(['cat_id' => $goods_type])->asArray()->all();

            foreach ($attr_res as $val) {

                $attr_list[$val['attr_id']] = $val['attr_index'];
            }*/

            $sql = "SELECT g.*, a.attr_type FROM {{%goods_attr}} AS g LEFT JOIN {{%attribute}} AS a ON a.attr_id = g.attr_id WHERE g.goods_id = '{$goods_id}'";

            $res = Yii::$app->db->createCommand($sql)->queryAll();

            $goods_attr_list = [];
            foreach ($res as $val) {
                $goods_attr_list[$val['attr_id']][$val['attr_value']] = ['sign' => 'delete', 'goods_attr_id' => $val['goods_attr_id']];
            }

            // 循环现有的，根据原有的做相应处理

            foreach ($_POST['attr_id_list'] AS $key => $attr_id) {
                $attr_value = $_POST['attr_value_list'][$key];
                $attr_price = $_POST['attr_price_list'][$key];

                if (!empty($attr_value)) {
                    if (isset($goods_attr_list[$attr_id][$attr_value])) {
                        // 如果原来有，标记为更新

                        $goods_attr_list[$attr_id][$attr_value]['sign'] = 'update';
                        $goods_attr_list[$attr_id][$attr_value]['attr_price'] = $attr_price;
                    } else {
                        // 如果原来没有，标记为新增

                        $goods_attr_list[$attr_id][$attr_value]['sign'] = 'insert';
                        $goods_attr_list[$attr_id][$attr_value]['attr_price'] = $attr_price;
                    }
                }
            }

            /* 插入、更新、删除数据 */

            foreach ($goods_attr_list as $attr_id => $attr_value_list) {

                foreach ($attr_value_list as $attr_value => $info) {

                    $data = [
                        'attr_id' => $attr_id,
                        'goods_id' => $goods_id,
                        'attr_value' => $attr_value,
                        'attr_price' => $info['attr_price']
                    ];

                    if ($info['sign'] == 'insert') {

                        Yii::$app->db->createCommand()->insert('{{%goods_attr}}', $data)->execute();
                    } elseif ($info['sign'] == 'update') {

                        Yii::$app->db->createCommand()->update('{{%goods_attr}}', $data, ['goods_attr_id' => $info['goods_attr_id']])->execute();
                    } else {

                        Yii::$app->db->createCommand()->delete('{{%goods_attr}}', ['goods_attr_id' => $info['goods_attr_id']])->execute();
                    }
                }
            }

        }
    }

}
