<?php

namespace sms;


class SmsVoicePromptSender {
    private $url;
    private $appid;
    private $appkey;
    
    function __construct($appid, $appkey) {
        $this->url = "https://sms.banling.com/intf/sendvoiceprompt";
        $this->appid =  $appid;
        $this->appkey = $appkey;
    }

    private function getRandom() {
        return rand(100000, 999999);
    }



    private function sendCurlPost($url, $dataObj) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($dataObj));
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $ret = curl_exec($curl);
        if (false == $ret) {
            // curl_exec failed
            $result = "{ \"result\":" . -2 . ",\"errmsg\":\"" . curl_error($curl) . "\"}";
        } else {
            $rsp = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if (200 != $rsp) {
                $result = "{ \"result\":" . -1 . ",\"errmsg\":\"". $rsp . " " . curl_error($curl) ."\"}";
            } else {
                $result = $ret;
            }
        }
        curl_close($curl);
        return $result;
    }
    
    /**
     * 语言通知发送
     * @param string $nationCode 国家码，如 86 为中国
     * @param string $phoneNumber 不带国家码的手机号
     * @param string $prompttype //语音类型，目前固定为2
     * @param string $promptfile 通知内容，utf8编码，支持中文英文、数字及组合，需要和语音内容模版相匹配
     * @param string $playtimes 播放次数
     * @param string $ext 服务端原样返回的参数，可填空串
     * @return string json string { "result": xxxxx, "errmsg": "xxxxxx" ... }，被省略的内容参见协议文档
     */
    function send($nationCode, $phoneNumber, $prompttype,$promptfile, $playtimes = 2, $ext = "") {
        /*
         {
         "tel": {
         "nationcode": "86", //国家码
         "mobile": "13788888888" //手机号码
         },
         "prompttype": 2, //语音类型，目前固定为2
         "promptfile": "语音内容文本", //通知内容，utf8编码，支持中文英文、数字及组合，需要和语音内容模版相匹配
         "playtimes": 2, //播放次数，可选，最多3次，默认2次
         "sig": "30db206bfd3fea7ef0db929998642c8ea54cc7042a779c5a0d9897358f6e9505", //app凭证，具体计算方式见下注
         "time": 1457336869, //unix时间戳，请求发起时间，如果和系统时间相差超过10分钟则会返回失败
         "ext": "" //用户的session内容，斑羚在线server回包中会原样返回，可选字段，不需要就填空。
         }
         }*/
        $random = $this->getRandom();
        $curTime = time();
        $wholeUrl = $this->url . "?sdkappid=" . $this->appid . "&random=" . $random;
        
        // 按照协议组织 post 包体
        $data = new \stdClass();
        $tel = new \stdClass();
        $tel->nationcode = "".$nationCode;
        $tel->mobile = "".$phoneNumber;
        
        $data->tel = $tel;
        $data->promptfile = $promptfile;
        $data->prompttype = $prompttype;//固定值
        $data->playtimes = $playtimes;
        $data->sig = hash("sha256",
                          "appkey=".$this->appkey."&random=".$random."&time=".$curTime."&mobile=".$phoneNumber, FALSE);
        $data->time = $curTime;
        $data->ext = $ext;
        return $this->sendCurlPost($wholeUrl, $data);
    }
}