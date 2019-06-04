<?php
include_once __DIR__ . DIRECTORY_SEPARATOR . 'helper.php';

$request = $_GET;

if(empty( $request)) {

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

    if(!isset($request['u']) || empty($request['u'])) {
        outJson([
            'code' => -1,
            'message' => '缺少用户名',
            'data' => [
            ]
        ]);
    }

    if(!isset($request['p']) || empty($request['p'])) {
        outJson([
            'code' => -1,
            'message' => '缺少密码',
            'data' => [
            ]
        ]);
    }

    if(!isset($request['m']) || empty($request['m'])) {
        outJson([
            'code' => -1,
            'message' => '缺少手机号',
            'data' => [
            ]
        ]);
    }

    if(!isset($request['c']) || empty($request['c'])) {
        outJson([
            'code' => -1,
            'message' => '缺少短信内容',
            'data' => [
            ]
        ]);
    }

    $params = [
        'u' => $request['u'],
        'p' => md5( $request['p']),
        'm' => substr( $request['m'], -11, 11),
        'c' => $request['c'],
    ];

    if(isset($request['sign']) || !empty($request['sign'])) {
        $params['c'] .= "【{$params['sign']}】";
    }

    $url = 'https://api.smsbao.com/sms';

    $res = getRequest($url, $params);

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