<?php
namespace Yunpian;

/**
 *
 * @author YangLong
 * Date: 2018-01-08
 */
class Yunpian
{

    private $apikey, $opts = [];

    public function setApiKey($apikey)
    {
        $this->apikey = $apikey;
    }

    public function setCurlOpt(array $opts)
    {
        $this->opts = $opts;
    }

    public function singleSend($mobile, $text)
    {
        $data = array(
            'text' => $text,
            'apikey' => $this->apikey,
            'mobile' => $mobile
        );
        
        $url = 'https://sms.yunpian.com/v2/sms/single_send.json';
        return $this->doQuery($url, $data);
    }

    private function doQuery($url, $data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        foreach ($this->opts as $key => $value) {
            curl_setopt($ch, $key, $value);
        }
        $json_data = curl_exec($ch);
        if (curl_error($ch) != "") {
            return curl_error($ch);
        }
        $result = json_decode($json_data);
        return $result;
    }
}

