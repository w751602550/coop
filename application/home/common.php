<?php

use think\facade\Request;

!defined('MEMBER') && define('MEMBER', 'bin_member');
function pwd_hash($pwd)
{
    return md5(md5($pwd . "_binbin"));
}


function toUnderScore($str)
{
    $dstr = preg_replace_callback('/([A-Z]+)/', function ($matchs) {
        return '_' . strtolower($matchs[0]);
    }, $str);
    return trim(preg_replace('/_{2,}/', '_', $dstr), '_');
}

function binJson($code = '', $msg = '', $url = '', $result = [])
{
    return compact('code', 'msg', 'url', 'result');
}

function ajaxSuccess($msg = '', $url = '', $data = [])
{
    return binJson(1, $msg, $url, $data);
}

function ajaxError($msg = '', $url = '', $data = [])
{
    return binJson(0, $msg, $url, $data);
}

function postData($key)
{
    return input($key . '/a');
}

function getData($key)
{
    return input($key . '/a');
}


function base_url()
{
    $request = Request::instance();
    $subDir = str_replace('\\', '/', dirname($request->server('PHP_SELF')));
    return $request->scheme() . '://' . $request->host() . $subDir . ($subDir === '/' ? '' : '/');
}

function getchina($key = '')
{
    $zh = [
        '' => '',
        'captchaError' => '验证码错误',
        'noMemberName' => '用户名不存在，请重新输入',
        'passwordError' => '密码错误,请重新输入',
        'loginSuccess' => '登录成功',
        'loginError' => '登录失败',
        'addSuccess' => '添加成功',
        'addError' => '添加失败',
        'updateSuccess' => '更新成功',
        'updateError' => '更新失败',
        'deleteSuccess' => '删除成功',
        'deleteError' => '删除失败',
        'noData'=>'该数据己删除或不存在',
        'hasSon'=>'存在下级类目,请先删除下级类目',
        'noParent'=>'上级类目不存在，请重新选择'
    ];
    return isset($zh[$key]) ? $zh[$key] : '';
}