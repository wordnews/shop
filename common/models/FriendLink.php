<?php

namespace common\models;

use Yii;

class FriendLink extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%friend_link}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['link_name'], 'required'],
            [['show_order', 'status'], 'integer'],
            [['link_name', 'link_url', 'link_logo'], 'string', 'max' => 255],
            [['link_logo'], 'file', 'extensions' => 'jpg, png, gif, jpeg', 'mimeTypes' => 'image/jpg, image/png, image/gif, image/jpeg'],
            [['status'], 'default', 'value' => function(){
                return 1;
            }],
            [['show_order'], 'default', 'value' => function(){
                return 50;
            }]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'link_id' => '链接ID',
            'link_name' => '链接名称',
            'link_url' => '链接地址',
            'link_logo' => '链接LOGO',
            'show_order' => '显示顺序',
            'status' => '状态',
        ];
    }

    /**
     * 修改状态
     * @param int $link_id id
     * @param int $status 状态码 [0, 1]
     * @return bool|int
     */
    public function setStatus($link_id, $status = 1){
        if (!in_array($status, [0, 1])) {
            return false;
        }
        return FriendLink::updateAll(['status' => $status], 'link_id = :link_id', [':link_id' => $link_id]);
    }
}
