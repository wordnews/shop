<?php

namespace common\models;

use Yii;

class Brand extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%brand}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['brand_name'], 'required'],
            [['brand_desc'], 'string'],
            [['sort', 'is_hot', 'status'], 'integer'],
            [['brand_name'], 'string', 'max' => 60],
            [['brand_logo'], 'string', 'max' => 80],
            [['site_url'], 'string', 'max' => 100],

            [['status'], 'default', 'value' => function(){
                return 1;
            }],
            [['sort'], 'default', 'value' => function(){
                return 50;
            }],

            [['brand_logo'], 'file', 'extensions' => 'jpg, png, gif, jpeg', 'mimeTypes' => 'image/jpg, image/png, image/gif, image/jpeg']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'brand_id' => '品牌ID',
            'brand_name' => '品牌名称',
            'brand_logo' => '品牌LOGO',
            'brand_desc' => '品牌描述',
            'site_url' => '品牌网址',
            'sort' => '排序',
            'is_hot' => '是否热销',
            'status' => '是否显示',
        ];
    }

    /**
     * 获取所有品牌
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getLists(){
        return $this->find()->where(['status' => 1])->orderBy('sort')->all();
    }

    /**
     * html 下拉 dropDownList 数组
     * @return array
     */
    public function dropListHtml(){
        $list = $this->find()->where(['status' => 1])->orderBy('sort')->all();

        $result[] = '所有品牌';
        foreach ($list as $val) {
            $result[$val['brand_id']] = $val['brand_name'];
        }
        return $result;
    }

    /**
     * 设置热销状态
     * @param $brand_id
     * @param int $status
     * @return bool|int
     */
    public function setHot($brand_id, $status = 1){
        if (!in_array($status, [0, 1])) {
            return false;
        }
        return Brand::updateAll(['is_hot' => $status], 'brand_id = :brand_id', [':brand_id' => $brand_id]);
    }

    /**
     * 设置显示状态
     * @param $brand_id
     * @param int $status
     * @return bool|int
     */
    public function setStatus($brand_id, $status = 1){
        if (!in_array($status, [0, 1])) {
            return false;
        }
        return Brand::updateAll(['status' => $status], 'brand_id = :brand_id', [':brand_id' => $brand_id]);
    }
}
