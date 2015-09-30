<?php

namespace common\models;

use Yii;

class ArticleCat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article_cat}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_name'], 'required'],
            [['cat_type', 'sort_order', 'show_in_nav', 'parent_id'], 'integer'],
            [['cat_name', 'keywords', 'cat_desc'], 'string', 'max' => 255],

            [['sort_order'], 'default', 'value' => function(){
                return 50;
            }],
            [['cat_type'], 'default', 'value' => function(){
                return 1;
            }],
            [['show_in_nav', 'parent_id'], 'default', 'value' => function(){
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
            'cat_name' => '文章分类名称',
            'cat_type' => '分类类型',
            'keywords' => '关键字',
            'cat_desc' => '描述',
            'sort_order' => '排序',
            'show_in_nav' => '是否显示在导航栏',
            'parent_id' => '上级分类',
        ];
    }

    /**
     * 获取分类 ( select下拉数组 )
     * @param int $cat_type 分类类型；1，普通分类；2，系统分类；3，网店信息；4，帮助分类；5，网店帮助
     * @param bool $is_det 是否需要默认分类
     * @return mixed
     */
    public function parent($cat_type = 0, $is_det = true){
        if ($cat_type == 0) {
            $query = $this->find();
        } else {
            $query = $this->find()->where('cat_type = :cat_type', [':cat_type' => $cat_type]);
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


    // 排序分类
    Public function parentSort($cate, $html = '&nbsp;&nbsp;&nbsp;&nbsp;', $pid = 0, $level = 0){
        $arr = array();
        foreach($cate as $v){
            if ($v['parent_id'] == $pid){
                $v['level'] = $level +1;
                $v['html'] = str_repeat($html, $level);
                $arr[] = $v;
                $arr = array_merge($arr, $this->parentSort($cate, $html, $v['cat_id'], $level + 1));

            }
        }
        return $arr;
    }

    /**
     * 所有分类 （ 'key' => 'value' ）的形式
     * @param int $cat_type 分类类型；1，普通分类；2，系统分类；3，网店信息；4，帮助分类；5，网店帮助
     * @return mixed
     */
    public function parentNews($cat_type = 0){
        if ($cat_type == 0) {
            $query = $this->find();
        } else {
            $query = $this->find()->where('cat_type = :cat_type', [':cat_type' => $cat_type]);
        }

        $list = $query->orderBy('sort_order')->asArray()->all();

        $list = $this->parentSort($list);

        // 组合成 （名 =》值） 的形式

        $listNews = ['0' => '全部分类'];

        foreach ($list as $val) {
            $listNews[$val['cat_id']] = $val['html'] . $val['cat_name'];
        }
        return $listNews;
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
        $result = ArticleCat::updateAll(['show_in_nav' => $status], 'cat_id = :cat_id', [':cat_id' => $cat_id]);

        if ($result) {
            $Nav = new Nav();

            if ($status == 1) { // 新增

                $Nav->addData('a', $cat_id);
            } else { // 删除

                $Nav->delData('a', $cat_id);
            }

            return true;
        }
        return false;
    }
}
