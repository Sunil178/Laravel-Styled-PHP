<?php

header('Content-Type: application/json; charset=utf-8');

$response = [];
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['status'] = 405;
    $response['message'] = "Method not allowed";
    echo json_encode($response);
    exit;
}

$json = file_get_contents('php://input');
$request = json_decode($json);

$required_fields = [ 'android_id', 'ipv4', 'ipv6', 'proxy', 'rotation', 'location', 'model', 'sdk_int' ];
foreach ($required_fields as $field) {
    if (!isset($request->$field) || $request->$field == '') {
        $response['status'] = 400;
        $response['message'] = "$field is required";
        echo json_encode($response);
        exit;
    }
}
$tracking_link = @$request->tracking_link ?: NULL;
$click_time = @$request->click_time ?: NULL;
$install_time = @$request->install_time ?: NULL;
$install_wait_time = @$request->install_wait_time ?: NULL;
$register_time = @$request->register_time ?: NULL;
$register_wait_time = @$request->register_wait_time ?: NULL;

if ( !$click_time && !$install_time && !$register_time ) {
    $response['status'] = 400;
    $response['message'] = "Any one is required: click time, install time, register time";
    echo json_encode($response);
    exit;
}

$model = new Model('bot_leads');

$bot_lead = $model->getByOne([ 'android_id' => $request->android_id ]);
if ($bot_lead === false) {
    $data = [
        'android_id' => $request->android_id,
        'ipv4' => $request->ipv4,
        'ipv6' => $request->ipv6,
        'proxy' => $request->proxy,
        'rotation' => $request->rotation,
        'location' => $request->location,
        'model' => $request->model,
        'sdk_int' => $request->sdk_int,
        'tracking_link' => $tracking_link,
        'click_time' => $click_time,
        'install_time' => $install_time,
        'install_wait_time' => $install_wait_time,
        'register_time' => $register_time,
        'register_wait_time' => $register_wait_time,
    ];
    $db_res = $model->create($data);
}
else {
    $response['status'] = 409;
    $response['message'] = "Bot lead already exists";
    echo json_encode($response);
    exit;
}

if ($db_res !== false) {
    $response['status'] = 200;
    $response['message'] = "Data saved successfully";
    echo json_encode($response);
    exit;
}

$response['status'] = 500;
$response['message'] = "Something went wrong";
echo json_encode($response);

?>