<?php

/**
 * 开发环境用得，上线删除
 * @param $array
 */
function dump($array){
    header('Content-Type:text/html; charset=utf-8');
    echo '<pre>';
    var_dump($array);
}