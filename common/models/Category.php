<?php

namespace common\models;

use Yii;

class Category extends \yii\db\ActiveRecord
{
    public $recommend_type; //首页推荐类型：1：精品，2：最新，3：热门

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_name'], 'required'],
            [['parent_id', 'sort_order', 'show_in_nav', 'is_show', 'grade'], 'integer'],
            [['cat_name'], 'string', 'max' => 90],
            [['keywords', 'cat_desc', 'filter_attr'], 'string', 'max' => 255],
            [['template_file'], 'string', 'max' => 50],
            [['measure_unit'], 'string', 'max' => 15],
            [['style'], 'string', 'max' => 150],

            [['sort_order'], 'default', 'value' => function(){
                return 50;
            }],
            [['filter_attr'], 'default', 'value' => function(){
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
            'cat_id' => '分类ID',
            'cat_name' => '分类名称',
            'keywords' => '关键字',
            'cat_desc' => '分类描述',
            'parent_id' => '上级分类',
            'sort_order' => '排序',
            'template_file' => 'Template File',
            'measure_unit' => '数量单位',
            'show_in_nav' => '是否显示在导航栏',
            'style' => '分类样式表文件',
            'is_show' => '是否显示',
            'grade' => '价格区间个数',
            'filter_attr' => '筛选属性',

            'recommend_type' => '设置为首页推荐'
        ];
    }

    /**
     * 获取分类 ( select下拉数组 , 有模型)
     * @param int $cat_id 上级分类id
     * @param bool $is_det 是否需要默认分类
     * @return mixed
     */
    public function parent($cat_id = 0, $is_det = true){
        if ($cat_id == 0) {
            $query = $this->find();
        } else {
            $query = $this->find()->where('cat_id = :cat_id', [':cat_id' => $cat_id]);
        }

        $list = $query->orderBy('sort_order')->asArray()->all();

        $list = $this->parentSort($list);

        foreach ($list as $key => $val) {
            $list[$key]['cat_name'] = $val['html'] . $val['cat_name'];

        }
        // 需要默认分类
        if ($is_det) {
            return array_merge([['cat_id' => 0, 'cat_name' => '顶级分类']], $list);
        }
        return $list;
    }

    /**
     * html 下拉 dropDownList 数组
     * @return array
     */
    public function dropListHtml(){
        $list = $this->find()->orderBy('sort_order')->asArray()->all();

        $list = $this->parentSort($list);

        $result[] = '所有分类';

        foreach ($list as $key => $val) {

            $result[$val['cat_id']] = $val['html'] . $val['cat_name'];
        }
        return $result;
    }


    // 排序分类
    Public function parentSort($list, $html = '&nbsp;&nbsp;&nbsp;&nbsp;', $pid = 0, $level = 0){
        $arr = array();
        foreach($list as $v){
            if ($v['parent_id'] == $pid){
                $v['level'] = $level +1;
                $v['html'] = str_repeat($html, $level);
                $arr[] = $v;
                $arr = array_merge($arr, $this->parentSort($list, $html, $v['cat_id'], $level + 1));

            }
        }
        return $arr;
    }


    /**
     * 修改分类 是否在导航栏显示 的状态
     * @param $cat_id
     * @param int $status
     * @return bool|int
     */
    public function show_in_nav($cat_id, $status = 1){
        if (!in_array($status, [0, 1])) {
            return false;
        }
        $result = Category::updateAll(['show_in_nav' => $status], 'cat_id = :cat_id', [':cat_id' => $cat_id]);

        if ($result) {
            $Nav = new Nav();

            if ($status == 1) { // 新增

                $Nav->addData('c', $cat_id);
            } else { // 删除

                $Nav->delData('c', $cat_id);
            }

            return true;
        }
        return false;
    }

    /**
     * 是否显示的状态
     * @param $cat_id
     * @param int $status
     * @return bool|int
     */
    public function is_show($cat_id, $status = 1){
        if (!in_array($status, [0, 1])) {
            return false;
        }
        return Category::updateAll(['is_show' => $status], 'cat_id = :cat_id', [':cat_id' => $cat_id]);
    }

}
