<?php

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
        'noData'=>'该数据己删除或不存在',
        'hasSon'=>'存在下级类目',
        'passwordError'=>'原密码错误',
        'addAuth'=>'请添加权限',
    ];
    if (!$message[$key])
        return '信息不存在';
    return $message[$key];
}
