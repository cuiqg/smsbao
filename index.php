<?php
include_once __DIR__ . DIRECTORY_SEPARATOR . 'helper.php';

$params = $_GET;

if(empty( $params)) {

    outJson([
        'code' => -1,
        'message' => '缺少参数',
        'data' => [
            'params' => [
                'u' => '平台的用户名',
                'p' => '平台登录密码',
                'm' => '接收的手机号;群发时多个手机号以逗号分隔，一次不要超过99个号码',
                'c' => '发送内容'
            ]
        ]
    ]);
} else {

    if(!isset($params['u']) || empty($params['u'])) {
        outJson([
            'code' => -1,
            'message' => '缺少用户名',
            'data' => [
            ]
        ]);
    }

    if(!isset($params['p']) || empty($params['p'])) {
        outJson([
            'code' => -1,
            'message' => '缺少密码',
            'data' => [
            ]
        ]);
    }

    if(!isset($params['m']) || empty($params['m'])) {
        outJson([
            'code' => -1,
            'message' => '缺少手机号',
            'data' => [
            ]
        ]);
    }

    if(!isset($params['c']) || empty($params['c'])) {
        outJson([
            'code' => -1,
            'message' => '缺少短信内容',
            'data' => [
            ]
        ]);
    }

    $params = [
        'u' => $params['u'],
        'p' => md5( $params['p']),
        'm' => $params['m'],
        'c' => $params['c'],
    ];

    $url = 'https://api.smsbao.com/sms'.'?'. http_build_query($params);
    $res = file_get_contents($url);


    $statusStr = array(
        "0" => "短信发送成功",
        "-1" => "参数不全",
        "-2" => "服务器空间不支持,请确认支持curl或者fsocket，联系您的空间商解决或者更换空间！",
        "30" => "密码错误",
        "40" => "账号不存在",
        "41" => "余额不足",
        "42" => "帐户已过期",
        "43" => "IP地址限制",
        "50" => "内容含有敏感词"
        );

    if($res > 0) {
        outJson([
            'code'    => -1,
            'message' => $statusStr[$res],
            'data'    => []
        ]);
    } else {
        outJson([
            'code'    => 0,
            'message' => $statusStr[$res],
            'data'    => [],
        ]);
    }
}