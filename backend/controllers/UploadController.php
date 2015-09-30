<?php

namespace backend\controllers;

use common\helpers\File;
use Yii;
use yii\helpers\Json;

/**
 * 负责后台文件的上传
 */
class UploadController extends CommonController
{

	/**
	 * 编辑器（kindeditor）上传图片
	 */
	public function actionUploadeditor(){
		if ($_FILES['imgFile']['error'] === 0) {
			$path = File::uploadEditor('imgFile', 'editor');

			if ($path) {
				exit( Json::encode(['error' => 0, 'url' => Yii::getAlias('@web/' . $path)]) );
			} else {
				exit( Json::encode(['error' => 1, 'message' => '上传失败']) );
			}
		}
	}


}
