<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%menu}}".
 *
 * @property integer $menu_id
 * @property string $title
 * @property string $url
 * @property integer $status
 */
class Menu extends \yii\db\ActiveRecord
{
    public $_child;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['status', 'sort', 'pid'], 'integer'],
            [['title'], 'string', 'max' => 20],
            [['url'], 'string', 'max' => 30],
            [['status'], 'default', 'value' => function(){
                return 1;
            }],
            [['sort', 'pid'], 'default', 'value' => function(){
                return 0;
            }]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'menu_id' => '菜单id',
            'pid' => '上级菜单',
            'title' => '菜单名称',
            'url' => 'url',
            'sort' => '排序',
            'status' => '状态',
        ];
    }

    /**
     * 菜单的子菜单个数
     * @param int $menu_id 菜单id
     * @return int|string
     */
    public function itemMenu($menu_id){
        return $this->find()->where(['pid' => $menu_id])->count();
    }

    /**
     * 修改菜单状态
     * @param int $menu_id 菜单id
     * @param int $status 状态码 [0, 1]
     * @return bool|int
     */
    public function setStatus($menu_id, $status = 1){
        if (!in_array($status, [0, 1])) {
            return false;
        }
        return Menu::updateAll(['status' => $status], 'menu_id = :menu_id', [':menu_id' => $menu_id]);
    }

    /**
     * 获取顶级分类
     * @return array|\yii\db\ActiveRecord[]
     */
    public function menuTop(){
        $menuTop =  $this->find()->where(['pid' => 0, 'status' => 1])->orderBy('sort')->all();
        return $menuTop ? $menuTop : array();
    }

    /**
     * 获取所有菜单 (tree)
     */
    public function menuAll(){
        $list = $this->find()->where(['status' => 1])->orderBy('sort')->all();
        $list = \common\helpers\Functions::list_to_tree_menu($list);

        $tree = [];
        // 组合成top菜单节点
        foreach ($list as $val) {
            $tree[] = [
                'label' => $val->title,
                'items' => $this->items($val->_child)
            ];
        }
        return $tree;
    }

    /**
     * 生成二级菜单节点
     * @param $_child
     * @return array
     */
    private function items($_child){

        $tree = [];

        if (is_array($_child)) {

            foreach ($_child as $val) {
                $tree[] = [
                    'label' => $val->title,
                    'url' => [$val->url]
                ];
            }
        }

        return $tree;
    }

    /**
     * 所有菜单tree
     */
    public function treeList(){
        $list = $this->find()->where(['status' => 1])->orderBy('sort')->asArray()->all();
        return \common\helpers\Functions::list_to_tree_menu($list);
    }

}
