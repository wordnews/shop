<?php

namespace common\models;

use Yii;

class RoleAction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%role_action}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['action_code', 'action_title'], 'required'],
            [['action_code', 'action_title'], 'string', 'max' => 60]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'action_id' => 'Action ID',
            'parent_id' => '上级角色节点',
            'action_code' => '角色节点唯一标识',
            'action_title' => '角色权限节点名称',
        ];
    }

    /**
     * 获取一级权限节点
     * @return array
     */
    public function getActionTop()
    {
        return $this->find()->where(['parent_id' => 0])->all();
    }

    /**
     * 获取下级节点的数量
     * @param int $parent_id
     * @return int|string
     */
    public function getNextCount($parent_id = 0)
    {
        return $this->find()->where(['parent_id' => $parent_id])->count();
    }

    /**
     * 获取节点的名称
     * @param int $action_id
     * @return mixed|string
     */
    public function getActionName($action_id = 0)
    {
        if ($action_id == 0) {
            return '顶级权限节点';
        } else {
            return $this->findOne($action_id)->action_title;
        }
    }

    // 所有权限节点tree
    public function treeList()
    {
        $list = $this->find()->asArray()->all();
        return $this->list_to_tree($list);
    }

    // 组合tree
    public function list_to_tree($list, $parent_id = 0)
    {
        // 创建Tree
        $tree = [];
        if (is_array($list)) {
            foreach ($list as $val) {
                if ($val['parent_id'] == $parent_id) {
                    $val['_child'] = $this->list_to_tree($list, $val['action_id']);
                    $tree[] = $val;
                }
            }

        }

        return $tree;
    }

}
