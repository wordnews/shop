<?php
namespace common\helpers;

use yii\web\UploadedFile;

/**
 * 负责文件的处理
 * Class File
 * @package common\helpers
 */
class File{

    /**
     * 公用上传图片的方法 (单图)
     * @param mixed $model  模型
     * @param string $attribute  字段属性
     * @param string $dir  uploads目录下的子目录名称（不存在自动创建）
     * @return string （图片保存的路径全称）
     */
    public static function uploadImage($model, $attribute, $dir = 'other'){
        $upload = UploadedFile::getInstance($model, $attribute);

        $pathName = self::savePath($upload->extension, $dir);

        /* 保存图片 */
        $upload->saveAs($pathName);
        return $pathName;
    }

    /**
     * 公用上传图片的方法 (多图)
     * @param mixed $model  模型
     * @param string $attribute  字段属性
     * @param string $dir  uploads目录下的子目录名称（不存在自动创建）
     * @return array （图片保存的路径全称数组）
     */
    public static function uploadImages($model, $attribute, $dir = 'other'){
        $upload = UploadedFile::getInstances($model, $attribute);

        $filePath = [];
        foreach ($upload as $file) {
            $pathName = self::savePath($file->extension, $dir);
            $file->saveAs($pathName);

            $filePath[] = $pathName;
        }
        return $filePath;
    }

    /**
     * 无模型上传图片
     * @param string $attribute 字段名
     * @param string $dir uploads目录下的子目录名称（不存在自动创建）
     * @return string
     */
    public static function uploadEditor($attribute, $dir = 'other'){
        $upload = UploadedFile::getInstanceByName($attribute);

        $pathName = self::savePath($upload->extension, $dir);

        /* 保存图片 */
        $upload->saveAs($pathName);
        return $pathName;
    }

    /**
     * 生成文件名
     * @param string $suffix 文件后缀
     * @param string $dir 子目录
     * @return string
     */
    private static function savePath($suffix, $dir = 'other'){
        $path = 'uploads/' . $dir . '/' . date('Ymd', time());
        /* 检查目录是否存在（不存在就创建） */
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        $pathName = $path . '/' . uniqid() . '.' . $suffix;

        return $pathName;
    }
}