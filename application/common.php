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
use think\facade\Request;

!defined('STORE') && define('STORE', 'bin_store');

function toUnderScore($str)
{
    $dstr = preg_replace_callback('/([A-Z]+)/', function ($matchs) {
        return '_' . strtolower($matchs[0]);
    }, $str);
    return trim(preg_replace('/_{2,}/', '_', $dstr), '_');
}

function base_url()
{
    $request = Request::instance();
    $subDir = str_replace('\\', '/', dirname($request->server('PHP_SELF')));
    return $request->scheme() . '://' . $request->host() . $subDir . ($subDir === '/' ? '' : '/');
}

function renderJson($code = 1, $msg = '', $url = '', $data = [])
{
    return compact('code', 'msg', 'url', 'data');
}

function ajaxSuccess($msg = 'success', $url = '', $data = [])
{
    return renderJson(1, $msg, $url, $data);
}

function ajaxError($msg = 'error', $url = '', $data = [])
{
    return renderJson(0, $msg, $url, $data);
}

function postData($key = null)
{
    return Request::post(is_null($key) ? '' : $key . '/a');
}

function getData($key = null)
{
    return Request::get(is_null($key) ? '' : $key . '/a');
}

function pwd_hash($pwd)
{
    return md5(md5($pwd . "_binbin"));
}

function getchina($key = '')
{
    $message = [
        '' => '',
        'addSuccess' => '添加成功',
        'addError' => '添加失败',
        'updateSuccess' => '更新成功',
        'updateError' => '更新失败',
        'deleteSuccess' => '删除成功',
        'deleteError' => '删除失败',
        'addAuth'=>'请添加权限',
        'captchaError' => '验证码错误',
        'noMemberName' => '用户名不存在，请重新输入',
        'passwordError' => '密码错误,请重新输入',
        'loginSuccess' => '登录成功',
        'loginError' => '登录失败',
        'noData'=>'该数据己删除或不存在',
        'hasSon'=>'存在下级类目,请先删除下级类目',
        'noParent'=>'上级类目不存在，请重新选择'
    ];
    return isset($message[$key]) ? $message[$key] : '';
}

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

