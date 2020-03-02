<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function encrypt($data, $method = 'DES-ECB', $passwd = 'binbin', $options = 0, $iv = '')
{
    return openssl_encrypt($data, $method, $passwd, $options);
}

function decrypt($data, $method = 'DES-ECB', $passwd = 'binbin', $options = 0, $iv = '')
{
    return openssl_decrypt($data, $method, $passwd, $options);
}

function subString($str, $length = 30)
{
    if (!$str)
        return;
    $length = max($length, 20);
    return mb_substr(strip_tags(str_replace('&nbsp;', '', htmlspecialchars_decode($str))), 0, $length, 'utf-8');
}

function convertUTF8($str)
{
    return mb_convert_encoding($str, 'utf-8');
}

function read_file($dir, $all = true)
{
    $result = [];
    if (!is_dir($dir))
        return;
    $data = scandir($dir);
    foreach ($data as $v) {
        $sub = $dir . $v . DS;
        if ($v == '.' || $v == '..') {
            continue;
        }
        if ($all) {
            if (is_dir($sub)) {
                $result[$v] = read_file($sub, $all);
            } else {
                $result[] = $v;
            }
        } else {
            array_push($result, $v);
        }

    }
    return $result;
}

function delete_file($dir)
{
    if (!is_dir($dir) && !is_file($dir))
        return;
    if (is_file($dir)) {
         unlink($dir);
    } elseif (!read_file($dir, false)) {
         rmdir($dir);
    } else {
        $files = scandir($dir);
        foreach ($files as $v) {
            if ($v == '.' || $v == '..') {
                continue;
            }
            delete_file($dir . DS . $v);
        }
        rmdir($dir);
    }
    return;
}

