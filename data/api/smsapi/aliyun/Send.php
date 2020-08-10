<?php
defined('ByCCYNet') or exit('Access Invalid!');

require_once(dirname(__FILE__) . DS . 'config.inc.php');

$GLOBALS['sms_options'] = $options;


/**
 * 发短信
 * @param $mobile
 * @param $content
 * @return array|bool
 */
function send_sms($mobile, $content)
{

    return Send::request($mobile, $content['code'], $content['template_code']);
}

class Send
{

    /**
     * 生成签名并发起请求
     *
     * @param string $mobile       手机号码
     * @param int    $code         验证码
     * @param string $templateCode 验证码模板
     * @param bool   $security     是否使用https
     * @return array|bool
     */
    final public static function request($mobile = '', $code = 0, $templateCode = '', $security = false)
    {
        // 短信模板/验证码
        $template = self::templateCode($templateCode, $code);

        $domain    = 'dysmsapi.aliyuncs.com';
        $apiParams = [
            "SignatureMethod"  => "HMAC-SHA1",
            "SignatureNonce"   => uniqid(mt_rand(0, 0xffff), true),
            "SignatureVersion" => "1.0",
            "AccessKeyId"      => $GLOBALS['sms_options']['access_key_id'],
            "Timestamp"        => gmdate('Y-m-d\TH:i:s\Z'),
            "Format"           => "JSON",
            "RegionId"         => "cn-hangzhou",
            "Action"           => "SendSms",
            "Version"          => "2017-05-25",
            "PhoneNumbers"     => $mobile,
            "SignName"         => $GLOBALS['sms_options']['sign_name'],
            "TemplateCode"     => $template['TemplateCode'],
            "TemplateParam"    => $template['TemplateParam'],
        ];
        ksort($apiParams);
        $sortedQueryStringTmp = '';
        foreach ($apiParams as $key => $value) {
            $sortedQueryStringTmp .= "&" . self::encode($key) . "=" . self::encode($value);
        }
        $stringToSign = "GET&%2F&" . self::encode(substr($sortedQueryStringTmp, 1));
        $sign         = base64_encode(hash_hmac('sha1', $stringToSign, $GLOBALS['sms_options']['access_key_secret'] . "&", true));
        $signature    = self::encode($sign);
        $url          = ($security ? 'https' : 'http') . "://{$domain}/?Signature={$signature}{$sortedQueryStringTmp}";
        try {
            $result = json_decode(self::fetchContent($url));
            if ($result->Code == 'OK') {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 短信模板
     * @param string $templateCode
     * @param        $code
     * @return array
     */
    final private static function templateCode($templateCode = '', $code)
    {
        $templateParam = ['code' => (string)$code];
        if (!empty($templateParam) && is_array($templateParam)) {
            $templateParam = json_encode($templateParam, JSON_UNESCAPED_UNICODE);
        }
        return ['code' => $code, 'TemplateParam' => $templateParam, 'TemplateCode' => $templateCode];
    }

    final private static function encode($str)
    {
        $res = urlencode($str);
        $res = preg_replace('/\+/', "%20", $res);
        $res = preg_replace('/\*/', "%2A", $res);
        $res = preg_replace("/%7E/", "~", $res);
        return $res;
    }

    final private static function fetchContent($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "x-sdk-client" => "php/2.0.0"
        ]);
        if (substr($url, 0, 5) == 'https') {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }
        $rtn = curl_exec($ch);
        if ($rtn === false) {
            trigger_error("[CURL_" . curl_errno($ch) . "]: " . curl_error($ch), E_USER_ERROR);
        }
        curl_close($ch);
        return $rtn;
    }
}