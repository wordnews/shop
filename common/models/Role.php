<?php

namespace common\models;

use Yii;

class Role extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%role}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_name'], 'required'],
            [['action_list', 'show_menu'], 'string'],
            [['role_name'], 'string', 'max' => 60],
            [['role_descript'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'role_id' => 'Role ID',
            'role_name' => '角色名称',
            'role_descript' => '角色描述',
            'action_list' => '权限标识列表',
        ];
    }

    /**
     * 新增（编辑）数据
     * @return bool
     */
    public function addData()
    {
        if ($this->validate()) {
            if ($_POST['menu_list']) {
                $this->show_menu = implode(',', $_POST['menu_list']);
            }
            if ($_POST['actions_list']) {
                $this->action_list = implode(',', $_POST['actions_list']);
            }
            return $this->save(false);
        }
    }

    /**
     * 字符串（$str）是否在字符串($strList)出现
     * @param $strList
     * @param $str
     * @return bool
     */
    public function isChecked($strList, $str)
    {
        $arr = explode(',', $strList);
        return in_array($str, $arr);
    }

}
