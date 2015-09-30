<?php

use yii\helpers\Html;
use common\helpers\Functions;


$this->title = $this->params['meta_title'] . $this->exTitle;
$this->params['breadcrumbs'][] = $this->params['meta_title'];

?>
<style>
    td a {
        color: #666;
        text-decoration: underline;
    }
    td a:hover {
        color: #000;
    }
</style>
<div class="menu-index">
    <div class="main_title_wrapper clear">
        <h3><?= Html::encode($this->params['meta_title']) ?></h3>
    </div>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th colspan="4">订单统计信息</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td width="20%">
                    <a href="javascript:;">待发货订单:</a>
                </td>
                <td width="30%">
                    <span style="color: red">200</span>
                </td>
                <td width="20%">
                    <a href="javascript:;">未确认订单:</a>
                </td>
                <td width="30%">
                    100
                </td>
            </tr>
            <tr>
                <td width="20%">
                    <a href="javascript:;">待支付订单:</a>
                </td>
                <td width="30%">
                    100
                </td>
                <td width="20%">
                    <a href="javascript:;">已成交订单数:</a>
                </td>
                <td width="30%">
                    100
                </td>
            </tr>
            <tr>
                <td width="20%">
                    <a href="javascript:;">新缺货登记:</a>
                </td>
                <td width="30%">
                    100
                </td>
                <td width="20%">
                    <a href="javascript:;">退款申请:</a>
                </td>
                <td width="30%">
                    100
                </td>
            </tr>
        </tbody>
    </table>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th colspan="4">商品统计信息</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td width="20%">
                    <a href="javascript:;">商品总数:</a>
                </td>
                <td width="30%">
                    199
                </td>
                <td width="20%">
                    <a href="javascript:;">库存警告商品数:</a>
                </td>
                <td width="30%">
                    <span style="color: red">109</span>
                </td>
            </tr>
            <tr>
                <td width="20%">
                    <a href="javascript:;">新品推荐数:</a>
                </td>
                <td width="30%">
                    100
                </td>
                <td width="20%">
                    <a href="javascript:;">精品推荐数:</a>
                </td>
                <td width="30%">
                    100
                </td>
            </tr>
            <tr>
                <td width="20%">
                    <a href="javascript:;">热销商品数:</a>
                </td>
                <td width="30%">
                    100
                </td>
                <td width="20%">
                    <a href="javascript:;">促销商品数:</a>
                </td>
                <td width="30%">
                    100
                </td>
            </tr>
        </tbody>
    </table>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th colspan="4">系统信息</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td width="20%">服务器操作系统:</td> <td width="30%"><?= PHP_OS ?></td>
                <td width="20%">Web 服务器:</td> <td width="30%"><span title="<?= $_SERVER['SERVER_SOFTWARE']?>"><?= Functions::truncate_utf8_string($_SERVER['SERVER_SOFTWARE'], 20); ?></span></td>
            </tr>
            <tr>
                <td width="20%">PHP 版本:</td> <td width="30%"><?= PHP_VERSION ?></td>
                <td width="20%">MySQL 版本:</td> <td width="30%"><?= mysql_get_server_info() ?></td>
            </tr>
            <tr>
                <td width="20%">安全模式:</td> <td width="30%"><?= (boolean) ini_get('safe_mode') ? '是' : '否' ?></td>
                <td width="20%">文件上传的最大大小:</td> <td width="30%"><?= ini_get('upload_max_filesize') ?></td>
            </tr>
            <tr>
                <td width="20%">时区设置:</td> <td width="30%"><?= function_exists("date_default_timezone_get") ? date_default_timezone_get() : '无需设置'; ?></td>
                <td width="20%">Socket 支持:</td> <td width="30%"><?= function_exists('fsockopen') ? '是' : '否' ?></td>
            </tr>
        </tbody>
    </table>

</div>

