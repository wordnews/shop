<?php

namespace common\models;

use Yii;

class Article extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_id', 'article_type', 'add_time', 'status'], 'integer'],
            [['cat_id', 'title'], 'required'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 150],
            [['author'], 'string', 'max' => 30],
            [['author_email'], 'string', 'max' => 60],
            [['keywords', 'description'], 'string', 'max' => 255],

            [['add_time'], 'default', 'value' => function(){
                return time();
            }],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'article_id' => '文章ID',
            'cat_id' => '文章分类',
            'title' => '文章标题',
            'content' => '内容',
            'author' => '作者',
            'author_email' => '作者Email',
            'keywords' => '文章关键字',
            'is_hot' => '是否热门',
            'article_type' => '文章类型',
            'add_time' => '创建时间',
            'description' => '描述',
            'status' => '是否显示',
        ];
    }

    /**
     * 热门状态修改
     * @param $article_id
     * @param int $status
     * @return bool|int
     */
    public function setHot($article_id, $status = 1){
        if (!in_array($status, [0, 1])) {
            return false;
        }
        return Article::updateAll(['is_hot' => $status], 'article_id = :article_id', [':article_id' => $article_id]);
    }

    /**
     * 是否显示状态修改
     * @param $article_id
     * @param int $status
     * @return bool|int
     */
    public function setStatus($article_id, $status = 1){
        if (!in_array($status, [0, 1])) {
            return false;
        }
        return Article::updateAll(['status' => $status], 'article_id = :article_id', [':article_id' => $article_id]);
    }

}
