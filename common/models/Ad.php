<?php

namespace common\models;

use Yii;

class Ad extends \yii\db\ActiveRecord
{

    public $ad_file;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ad}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['position_id', 'media_type', 'click_count', 'enabled'], 'integer'],
            [['ad_name'], 'required'],
            [['ad_code'], 'string'],
            [['ad_name', 'link_man', 'link_email', 'link_phone', 'ad_code'], 'string', 'max' => 60],
            [['ad_link'], 'string', 'max' => 255],

            [['position_id'], 'default', 'value' => function(){
                return 0;
            }],
            [['click_count'], 'default', 'value' => function(){
                return 0;
            }],
            [['start_time', 'end_time'], 'filter', 'filter' => function ($value) {
                return strtotime($value);
            }],

            [['ad_file'], 'file', 'extensions' => 'jpg, png, gif, jpeg', 'mimeTypes' => 'image/jpg, image/png, image/gif, image/jpeg']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ad_id' => '广告ID',
            'position_id' => '广告位置',
            'media_type' => '媒介类型',
            'ad_name' => '广告名称',
            'ad_link' => '广告链接',
            'ad_code' => '媒介类型内容',
            'ad_file' => '媒介类型文件',
            'start_time' => '开始日期',
            'end_time' => '结束日期',
            'link_man' => '广告联系人',
            'link_email' => '联系人Email',
            'link_phone' => '联系电话',
            'click_count' => '点击次数',
            'enabled' => '是否开启',
        ];
    }

    /**
     * 媒介类型
     * @return array
     */
    public function media_type_list(){
        return [
            '0' => '图片',
            '1' => 'Flash',
            '2' => '代码',
            '3' => '文字'
        ];
    }

    public function setEnabled($ad_id, $status = 1){
        if (!in_array($status, [0, 1])) {
            return false;
        }
        return Ad::updateAll(['enabled' => $status], 'ad_id = :ad_id', [':ad_id' => $ad_id]);
    }

    /**
     * 广告类型的input框
     * @param int $media_type 广告类型
     * @return string
     */
    public function media_type_html($media_type = 0)
    {
        if ($media_type == 0 || $media_type == 1) {
            $html = '<div class="form-group field-ad-ad_file has-success">
<label class="col-sm-2 control-label" for="ad-ad_file">媒介类型文件</label>
<div class="col-xs-5"><input type="hidden" name="Ad[ad_file]" value=""><input type="file" id="ad-ad_file" name="Ad[ad_file]"></div></div>';
        } else {
            $html = '<div class="form-group field-ad-ad_code has-success">
<label class="col-sm-2 control-label" for="ad-ad_code">媒介类型内容</label>
<div class="col-xs-5"><textarea id="ad-ad_code" class="form-control" name="Ad[ad_code]" rows="3"></textarea></div></div>';
        }
        return $html;
    }

}
