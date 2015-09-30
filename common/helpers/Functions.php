<?php

namespace common\helpers;

/**
 * 写一下方法
 * Class Functions
 * @package common\helpers
 */
class Functions{

    /**
     * 把返回的数据集转换成Tree ( 后台菜单 )
     * @param $list
     * @param int $pid
     * @return array
     */
    public static function list_to_tree_menu($list, $pid = 0)
    {
        // 创建Tree
        $tree = [];
        if (is_array($list)) {
            foreach ($list as $val) {
                if ($val['pid'] == $pid) {
                    $val['_child'] = self::list_to_tree_menu($list, $val['menu_id']);
                    $tree[] = $val;
                }
            }

        }

        return $tree;
    }

    /**
     * 截取中文字符长度
     * @param string $string 截取的字符串
     * @param int $length 保留的长度
     * @param string $etc 省略字符
     * @return string 截取后得字符串
     */
    public static function truncate_utf8_string($string, $length, $etc = '...'){
        $result = '';
        $string = html_entity_decode(trim(strip_tags($string)), ENT_QUOTES, 'UTF-8');
        $strlen = strlen($string);
        for ($i = 0; (($i < $strlen) && ($length > 0)); $i++)
        {
            if ($number = strpos(str_pad(decbin(ord(substr($string, $i, 1))), 8, '0', STR_PAD_LEFT), '0'))
            {
                if ($length < 1.0)
                {
                    break;
                }
                $result .= substr($string, $i, $number);
                $length -= 1.0;
                $i += $number - 1;
            }
            else
            {
                $result .= substr($string, $i, 1);
                $length -= 0.5;
            }
        }
        $result = htmlspecialchars($result, ENT_QUOTES, 'UTF-8');
        if ($i < $strlen)
        {
            $result .= $etc;
        }
        return $result;
    }

    /**
     * 返回单个错误信息
     * @param array $error rules方法验证没有通过的错误信息数组
     * @return string
     */
    public static function getErrors($error){
        if ($error && is_array($error)) {
            foreach ($error as $err) {
                return $err;
            }
        }
        return '';
    }


}