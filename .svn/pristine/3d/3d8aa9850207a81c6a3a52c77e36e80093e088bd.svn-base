<?php


namespace app\home\controller;
use think\captcha\Captcha as cap;

class Captcha
{
    public function makecode()
    {
        $config = [
            'fontSize' => 20, // // 验证码字体大小
            'length' => 4, // 验证码位数
            'useNoise' => false,//是否添加杂点
            'useCurve' =>true,
            'imageH' => 50,//高度
            'imageW' => 150,
        ];
        $captcha = new cap($config);
        return $captcha->entry();
    }

    public function check()
    {
        $config = config('captcha');
        if(input('param.reset')=='false'){
            $config['reset'] = FALSE;
        }
        $captcha = new cap($config);
        $code = input('param.captcha');
        if ($captcha->check($code)) {
            exit('true');
        }else {
            exit('false');
        }
    }
}