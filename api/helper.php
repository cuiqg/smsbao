<?php

function getRequest($url, $params = []) {

    if(!empty($params)) {

        $url .= '?' . http_build_query($params);
    }

    return file_get_contents($url);

}

function outJson($data = []) {

    header("X-AUTHOR-BY: TsuiQG");
    header("Content-Type: application/json; charset=utf-8");
    echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
    exit;
}
