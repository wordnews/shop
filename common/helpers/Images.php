<?php
namespace common\helpers;

use yii\imagine\Image;
use Imagine\Image\Point;

/**
 * 图片处理类（负责图片的处理）
 * Class Images
 * @package common\helpers
 */
class Images
{

	/**
	 * 裁剪图片
	 * @param $filename string 图片全路径（./uploads/editor/20150516/demo.jpg）
	 * @param int    $width  裁剪后的宽
	 * @param int    $height 裁剪后的高
	 * @param string $qz     裁剪后图片的前缀
	 * @param string $type   裁剪类型 [居中裁剪（'center'）]
	 * @return string
	 */
	public static function crop($filename, $width = 200, $height = 200, $qz = 'crop_', $type = 'center'){
		// 获取图片居中裁剪的 x坐标，y坐标
		$info   = getimagesize($filename);

		// 判断，裁剪后图片的宽高不能大于原图的宽高
		if($info[0] < $width) $width = $info[0];
		if($info[1] < $height) $height= $info[1];

		switch ($type) { // 目前我只用到了居中裁剪，需要其他的裁剪方式自己加就好了

			case 'center': // 居中裁剪坐标
				$x = ($info[0] - $width) * 0.5;
				$y = ($info[1] - $height) * 0.5;
				break;

			default: // 默认居中裁剪坐标
				$x = ($info[0] - $width) * 0.5;
				$y = ($info[1] - $height) * 0.5;
		}

		$saveName = self::qz($filename, $qz);
		// 保存图片
		Image::crop($filename, $width, $height, [$x, $y])->save($saveName); // save()方法有第二个参数数组，可以设置保存图片的质量 save($savename, ['quality' => 80]);

		return trim($saveName, './');
	}

	/**
	 * 缩略图片
	 * @param string $filename 图片全路径（./uploads/editor/20150516/demo.jpg）
	 * @param int $width   缩略图的宽
	 * @param int $height  缩略图的高
	 * @param bool $pro    是否等比例缩放
	 * @param string $qz   缩略图的前缀
	 * @param string $type 缩略的类型（有两种：1、outbound，2、inset（不推荐））
	 * @return string
	 */
	public static function thumb($filename, $width = 200, $height = 200, $pro = false, $qz = 'thumb_', $type = 'outbound'){
		if ($pro) { // 计算等比例缩放的宽高
			$info   = getimagesize($filename);
			$tWidth = $info[0] / $width;
			$tHeight = $info[1] / $height;

			if ($tWidth > $tHeight) {
				$height = ceil($info[1] / $tWidth);
			} elseif($tWidth < $tHeight) {
				$width = ceil($info[0] / $tHeight);
			}
		}

		$saveName = self::qz($filename, $qz);
		// 保存图片
		Image::thumbnail($filename, $width, $height, $type)->save($saveName); // save()方法有第二个参数数组，可以设置保存图片的质量 save($savename, ['quality' => 80]);

		return trim($saveName, './');
	}

	/**
	 * 给图片加水印
	 * @param string $filename 原图全路径
	 * @param string $file 水印图片全路径
	 * @param string $type 水印位置
	 * @param string $qz
	 */
	public static function point($filename, $file, $type = 'center',$qz = 'po_'){
		$imagine = Image::getImagine();

		$image     = $imagine->open($filename); //打开原图
		$watermark = $imagine->open($file); // 打开水印图片

		$size  = $image->getSize(); // 获取原图的大小
		$wSize = $watermark->getSize(); // 获取水印图片的大小

		$width  = $size->getWidth();    // 原图宽
		$height = $size->getHeight();   // 原图高
		$wWidth = $wSize->getWidth();   // 水印宽
		$wHeight = $wSize->getHeight(); // 水印高

		switch ($type) {
			case 'center': // 水印在图片中间
				$x = round(($width - $wWidth) / 2);
				$y = round(($height - $wHeight) / 2);
				break;
			case 'top': // 居中正上方
				$x = round(($width - $wWidth) / 2);
				$y = 0;
				break;
			case 'rTop': // 最上面右边
				$x = $width - $wWidth;
				$y = 0;
				break;
			case 'rBottom': // 右下
				$x = $width - $wWidth;
				$y = $height - $wHeight;
				break;
			default:
				$x = $width - $wWidth;
				$y = $height - $wHeight;
		}

		$position = new Point ( $x, $y );
		$image -> paste ( $watermark , $position );
		$image->save(self::qz($filename, $qz));
	}

	/**
	 * 旋转图片
	 * @param string $filename 图片全路径
	 * @param int $angle 旋转的角度（lt 0 坐旋转，gt 0 右旋转）
	 * @param string $qz
	 * @param int $margin 边框大小
	 * @param string $color 边框颜色（有边框才会有颜色）
	 */
	public static function rotate($filename, $angle, $qz = 'ro_', $margin = 0, $color = '666'){
		Image::frame($filename, $margin, $color, 100)->rotate($angle)->save(self::qz($filename, $qz));
	}

	/**
	 * 过滤图片颜色成灰色
	 * @param string $filename 图片全路径
	 * @param string $qz  保存图片的前缀
	 */
	public static function gray($filename, $qz = 'gray'){
		$image = Image::getImagine();
		$newImage = $image->open($filename);
		$newImage->effects()->grayscale();

		// 保存图片
		$newImage->save(self::qz($filename, $qz));
	}

	/**
	 * 滤镜成胶卷图片
	 * @param string $filename 图片全路径
	 * @param float $float 滤镜数值（0-10之间、可以是整形和浮点型，数值越小越黑，越大越白）
	 * @param string $qz
	 */
	public static function neGamma($filename, $float = 1.3, $qz = 'negamma_'){
		$image = Image::getImagine();
		$newImage = $image->open($filename);
		$newImage->effects()->negative()->gamma($float);
		$newImage->save(self::qz($filename, $qz));
	}

	/**
	 * 加深（或变浅）图片颜色
	 * @param string $filename 图片全路径
	 * @param float $float 滤镜数值（0-10之间、可以是整形和浮点型，数值越小越黑，越大越白）
	 * @param string $qz
	 */
	public static function gamma($filename, $float = 1.3, $qz = 'gamma_'){
		$image = Image::getImagine();
		$newImage = $image->open($filename);
		$newImage->effects()->gamma($float);
		$newImage->save(self::qz($filename, $qz));
	}




	/**
	 * 给全路径的图片加上前缀
	 * @param string $filename  原图路径
	 * @param string $qz 前缀
	 * @return string  加了前缀的全路径
	 */
	private static function qz($filename, $qz){
		$save     = dirname($filename) . '/';
		$name     = explode('/', $filename);
		return $save . $qz . end($name);
	}


}