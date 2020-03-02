<?php


namespace app\home\controller\payment\unionpay;

use app\home\controller\payment\Payment;

define('transResvered', "trans_");
define('cardResvered', "card_");
define('transResveredKey', "TranReserved");
define('signatureField', "Signature");

class Unionpay extends Payment
{
    protected $merid = '541171910140001';

    private function getUrl($code)
    {
        $url = [
            'query_url' => 'https://payment.chinapay.com/CTITS/service/rest/forward/syn/000000000060/0/0/0/0/0',
            'pay_url' => 'https://payment.chinapay.com/CTITS/service/rest/page/nref/000000000017/0/0/0/0/0',
            'refund_url' => 'https://payment.chinapay.com/CTITS/service/rest/forward/syn/000000000065/0/0/0/0/0'
        ];
        return $url[$code];
    }

    public function bulidSign($data)
    {
        $data['MerId'] = '541171910140001';
        $transResvedJson = [];
        $cardInfoJson = [];
        $sendMap = [];
        foreach ($data as $key => $value) {
            if ($this->isEmpty($value)) {
                continue;
            }
            if ($this->startWith($key, transResvered)) {
                $key = substr($key, strlen(transResvered));
                $transResvedJson[$key] = $value;
            } else
                if ($this->startWith($key, cardResvered)) {
                    $key = substr($key, strlen(cardResvered));
                    $cardInfoJson[$key] = $value;
                } else {
                    $sendMap[$key] = $value;
                }
        }
        $transResvedStr = null;
        $cardResvedStr = null;
        if (count($transResvedJson) > 0) {
            $transResvedStr = json_encode($transResvedJson);
        }
        if (count($cardInfoJson) > 0) {
            $cardResvedStr = json_encode($cardInfoJson);
        }
        $secssUtil = new SecssUtil();
        if (!$this->isEmpty($transResvedStr)) {
            $transResvedStr = $secssUtil->decryptData($transResvedStr);
            $sendMap[transResveredKey] = $transResvedStr;
        }
        if (!$this->isEmpty($cardResvedStr)) {
            $cardResvedStr = $secssUtil->decryptData($cardResvedStr);
            $sendMap[cardResveredKey] = $cardResvedStr;
        }
        $securityPropFile = APP_PATH . "payment/unionpay/config/security.properties";
        $secssUtil->init($securityPropFile);
        $secssUtil->sign($sendMap);
        $sendMap[signatureField] = $secssUtil->getSign();
        //dump($sendMap);die;
        echo $this->buildForm($sendMap, $this->getUrl('pay_url'));
    }

    public function buildForm($data, $url)
    {
        $formData = '';
        foreach ($data as $key => $val) {
            $formData .= "<input type='hidden' name='$key' id='$key' value='$val'>";
        }
        $str = <<<HTML
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body onload="javascript:document.pay_form.submit();">
    <form id="pay_form" name="pay_form" action="$url" method="post">
   $formData
   <!-- <input type="submit" type="hidden">-->
    </form>
</body>
</html>
HTML;
        return $str;
    }

    protected function startWith($str, $needle)
    {
        return strpos($str, $needle) === 0;
    }

    protected function isEmpty($str)
    {
        return $str == null || strlen(trim($str)) == 0 ? true : false;
    }
}