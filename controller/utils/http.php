<?php

function getResponse($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

    $model = new Model('tokens');
    $token = $model->getByOne( [ 'status' => '1' ] );
    
    $headers = array();
    $headers[] = 'Authorization: Bearer ' . $token->key;
    $headers[] = 'Accept: application/json';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    $result = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if (curl_errno($ch)) {
        return false;
    }
    curl_close($ch);

    if ($http_code == 400) {
        return false;
    }
    $result = json_decode($result, true);
    if (!$result) {
        return false;
    }
    return $result;
}

function checkOrder($order_id) {
    $url = "https://5sim.net/v1/user/check/$order_id";
    return getResponse($url);
}

function getProfile() {
    $url = "https://5sim.net/v1/user/profile";
    return getResponse($url);
}

?>
