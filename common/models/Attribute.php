<?php

namespace common\models;

use Yii;

class Attribute extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%attribute}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_id', 'attr_input_type', 'attr_type', 'attr_index', 'sort_order', 'is_linked', 'attr_group'], 'integer'],
            [['attr_name', 'cat_id'], 'required'],
            [['attr_values'], 'string'],
            [['attr_name'], 'string', 'max' => 60],

            [['sort_order'], 'default', 'value' => function(){
                return 50;
            }],
            [['attr_group'], 'default', 'value' => function(){
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
            'attr_id' => '属性ID',
            'cat_id' => '商品类型',
            'attr_name' => '属性名称',
            'attr_input_type' => '录入方式', // 0，为手工输入；1，为选择输入；2，为多行文本输入
            'attr_type' => '属性是否可选',
            'attr_values' => '可选值列表',
            'attr_index' => '是否可以检索',
            'sort_order' => '排序',
            'is_linked' => '相同属性值的商品是否关联',
            'attr_group' => '属性分组',
        ];
    }

    /**
     * 根据属性数组创建属性的表单
     * @param int $cat_id 商品类型id
     * @param int $goods_id 商品id
     * @return string
     */
    public function attributeHtml($cat_id, $goods_id = 0)
    {
        if ($cat_id < 1) {
            return '';
        }

        $attr = $this->get_attr_list($cat_id, $goods_id);

        $html = '';
        $spec = 0;
        foreach ($attr as $val) {
            if ($val['attr_input_type'] == 0 || $val['attr_input_type'] == 2) { // 单行、多行输入框

                $html .= $this->createText($val);
            } else { // 下拉选择框

                $html .= $this->createSelect($val, $spec);

                $spec = $val['attr_id'];
            }
        }
        return $html;
    }

    /**
     * 取得通用属性和某分类的属性，以及某商品的属性值
     * @param int $cat_id 分类编号
     * @param int $goods_id 商品id
     * @return array 规格与属性列表
     */
    public function get_attr_list($cat_id, $goods_id = 0)
    {
        if (empty($cat_id)) {
            return array();
        }

        $sql = "SELECT a.attr_id, a.attr_name, a.attr_input_type, a.attr_type, a.attr_values, v.attr_value, v.attr_price FROM {{%attribute}} AS a LEFT JOIN {{%goods_attr}} AS v ON v.attr_id = a.attr_id AND v.goods_id = '{$goods_id}' WHERE a.cat_id = '{$cat_id}' OR a.cat_id = 0 ORDER BY a.sort_order, a.attr_type, a.attr_id, v.attr_price, v.goods_attr_id";

        return Yii::$app->db->createCommand($sql)->queryAll();
    }

    /**
     * 创建表单输入框
     * @param $attr
     * @return string
     */
    private function createText($attr)
    {
        $html = '';

        $html .= "<div class='form-group'>
                    <label class='col-sm-2 control-label'>{$attr['attr_name']}</label>
                    <div class='col-xs-5'>";

        $html .= "<input type='hidden' name='attr_id_list[]' value='{$attr['attr_id']}' />";

        if ($attr['attr_input_type'] == 0) {

            $html .= "<input type=\"text\" class=\"form-control\" name=\"attr_value_list[]\" value='{$attr['attr_value']}'>";
        } else {

            $html .= "<textarea class=\"form-control\" name=\"attr_value_list[]\">{$attr['attr_value']}</textarea>";
        }

        $html .= ($attr['attr_type'] == 1 || $attr['attr_type'] == 2) ? '属性价格 <input type="text" name="attr_price_list[]" value="' . $attr['attr_price'] . '" size="5" maxlength="10" />' : ' <input type="hidden" name="attr_price_list[]" value="0" />';

        $html .= '
                </div>
            </div>';
        return $html;
    }

    /**
     * 创建下拉选择框
     * @param $attr
     * @return string
     */
    private function createSelect($attr, $spec = 0)
    {
        $attr_values = explode("\r\n", $attr['attr_values']);

        if ($attr['attr_type'] == 1 || $attr['attr_type'] == 2){

            if ($attr['attr_id'] != $spec) {
                $spec = "<a href='javascript:;' onclick='addSpec(this)'>[+]</a>";
            } else {
                $spec = "<a href='javascript:;' onclick='removeSpec(this)'>[-]</a>";
            }
        }

        $html = '';

        $html .= "<div role=\"tabpanel\" class=\"tab-pane shop-pane\">
                    <div class=\"form-group\">
                        <label class=\"col-sm-2 control-label\" >{$spec}{$attr['attr_name']}</label>
                        <div class=\"col-xs-5\">";

        $html .= "<input type='hidden' name='attr_id_list[]' value='{$attr['attr_id']}' />";

        $style1 = ($attr['attr_type'] == 1 || $attr['attr_type'] == 2) ? 'style="width: 65%; display: inline"' : '';

        $html .= "<select class=\"form-control\" name=\"attr_value_list[]\" {$style1}>";

        $html .= '<option value="">请选择...</option>';

        foreach ($attr_values as $val) {
            $selected = $val == $attr['attr_value'] ? ' selected' : '';

            $html .= "<option value='{$val}'{$selected}>{$val}</option>";
        }


        $html .= "</select>";

        $html .= ($attr['attr_type'] == 1 || $attr['attr_type'] == 2) ? ' 属性价格 <input type="text" class="form-control" name="attr_price_list[]" value="' . $attr['attr_price'] . '" size="5" maxlength="10" style="width: 21%; display: inline" />' : ' <input type="hidden" name="attr_price_list[]" value="0" />';

        $html .= "</div>
                </div>
            </div>";

        return $html;
    }

}
