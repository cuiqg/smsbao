<?php

if(! function_exists('curlRequest')) {

    function curlRequest($url, $params = [], $method = 'get', $header = [], $timeout = 3) {

        if(strcasecmp($method, 'get') == 0 && !empty($params)) {

            $url .= '?' . http_build_query($params);
        }

        $ch = curl_init();

        $opts = [
            CURLOPT_URL            => $url,
            CURLOPT_BINARYTRANSFER => TRUE,
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_SSL_VERIFYHOST => FALSE,
            CURLOPT_USERAGENT      => 'TsuiQG/1.0',
            CURLOPT_TIMEOUT        => $timeout
        ];

        if(strcasecmp($method, 'post') == 0) {
            $opts[CURLOPT_POST]       = TRUE;
            $opts[CURLOPT_POSTFIELDS] = $params;
        }

        if(!empty($header)) {
			$opts[CURLOPT_HTTPHEADER] = $header;
        }

        curl_setopt_array($ch, $opts);
        
        $res = curl_exec($ch);
        $error = curl_error($ch);
        $errno = curl_errno($ch);

        if($errno) {
            return [
                'error' => true,
                'msg' => $error,
            ];
        }

        $res_dec = json_decode($res, true);

        if( json_last_error()) {
            return [
                'error' => false,
                'msg'   => '请求成功',
                'res'   => $res,
            ];
        } else {
            return [
                'error' => false,
                'msg'   => '请求成功',
                'res'   => $res_dec,
            ];
        }
    }

    function outText($text = '', $status = 200) {
        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
        header("Contetn-Type: text/html");
        ob_start();
        echo $text;
        ob_end_flush();
    }
}