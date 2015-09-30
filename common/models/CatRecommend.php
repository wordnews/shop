<?php

namespace common\models;

use Yii;

/**
 * 分类推荐表模型
 * Class CatRecommend
 * @package common\models
 */
class CatRecommend extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cat_recommend}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_id', 'recommend_type'], 'required'],
            [['cat_id', 'recommend_type'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cat_id' => '商品分类id',
            'recommend_type' => '首页推荐类型：1：精品，2：最新，3：热门',
        ];
    }

    /**
     * 新增分类推荐
     * @param $cat_id
     * @param array $recommend_type 必须是一个数组
     */
    public function insertRecommend($cat_id, $recommend_type){

        if ($recommend_type && is_array($recommend_type)) {
            // 删除以前的数据
            CatRecommend::deleteAll('cat_id = :cat_id', [':cat_id' => $cat_id]);

            $sql = "INSERT INTO {{%cat_recommend}} (`cat_id`, `recommend_type`) VALUES ";
            // 新增现在的
            foreach ($recommend_type as $val) {

                $sql .= "({$cat_id}, {$val}),";
            }

            Yii::$app->db->createCommand(trim($sql, ','))->execute();
        }
    }

    /**
     * 获取分类的推荐
     * @param int $cat_id
     * @return mixed
     */
    public function catRecommend($cat_id){
        $list = $this::findAll(['cat_id' => $cat_id]);

        if ($list) {
            $result = [];
            foreach ($list as $val) {
                $result[] = $val->recommend_type;
            }
            return $result;
        }
        return '';
    }

}
