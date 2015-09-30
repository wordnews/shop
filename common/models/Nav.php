<?php

namespace common\models;

use Yii;

class Nav extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%nav}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['cid', 'ifshow', 'vieworder', 'opennew'], 'integer'],
            [['ctype', 'type'], 'string', 'max' => 10],
            [['name', 'url'], 'string', 'max' => 255],

            [['vieworder'], 'default', 'value' => function(){
                return 50;
            }],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ctype' => 'Ctype',
            'cid' => 'Cid',
            'name' => '导航名称',
            'ifshow' => '是否显示',
            'vieworder' => '排序',
            'opennew' => '是否新窗口打开',
            'url' => '链接地址',
            'type' => '导航位置',
        ];
    }

    /**
     * 其他分类需要显示在导航栏的新增方法
     * @param string $ctype 其他分类表标识 a:文章分类表，c:商品分类表
     * @param int $cid 其他表分类id
     * @return mixed
     */
    public function addData($ctype, $cid){

        // 如果已经存在就不继续执行了
        if ($this->find()->where(['ctype' => $ctype, 'cid' => $cid])->one()) {
            return true;
        }

        switch ($ctype) {
            case 'a': // 文章分类
                $this->name = ArticleCat::findOne($cid)->cat_name;
                $this->url = ''; // 前台还没有做，暂时空起
                break;
            case 'c': // 商品分类
                $this->name = Category::findOne($cid)->cat_name;
                $this->url = ''; // 前台还没有做，暂时空起
                break;
            default:
                return false;
        }
        $this->ctype = $ctype;
        $this->cid = $cid;
        $this->type = 'middle';
        if ($this->insert(false)) {
            return true;
        }
        return false;
    }

    /**
     * 删除其他分类的导航
     * @param $ctype
     * @param $cid
     * @return bool
     */
    public function delData($ctype, $cid){
        switch ($ctype) {
            case 'a': // 文章分类
                return $this->deleteAll(['ctype' => 'a', 'cid' => $cid]);

            case 'c': // 商品分类
                return $this->deleteAll(['ctype' => 'c', 'cid' => $cid]);

            default:
                return false;
        }

    }


    /**
     * 是否显示状态修改
     * @param $id
     * @param int $status
     * @return bool|int
     */
    public function setIfshow($id, $status = 1){
        if (!in_array($status, [0, 1])) {
            return false;
        }
        return Nav::updateAll(['ifshow' => $status], 'id = :id', [':id' => $id]);
    }

    /**
     * 是否新窗口打开状态修改
     * @param $id
     * @param int $status
     * @return bool|int
     */
    public function setOpennew($id, $status = 1){
        if (!in_array($status, [0, 1])) {
            return false;
        }
        return Nav::updateAll(['opennew' => $status], 'id = :id', [':id' => $id]);
    }


}
