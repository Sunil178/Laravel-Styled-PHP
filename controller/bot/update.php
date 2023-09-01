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

if (!isset($request->android_id) || $request->android_id == '') {
    $response['status'] = 400;
    $response['message'] = "android_id is required";
    echo json_encode($response);
    exit;
}
$install_time = @$request->install_time ?: NULL;
$install_wait_time = @$request->install_wait_time ?: NULL;
$register_time = @$request->register_time ?: NULL;
$register_wait_time = @$request->register_wait_time ?: NULL;

if ( !$install_time && !$install_wait_time && !$register_time && !$register_wait_time ) {
    $response['status'] = 400;
    $response['message'] = "Any one is required: install time, install wait time, register time, register wait time";
    echo json_encode($response);
    exit;
}

$model = new Model('bot_leads');

$bot_lead = $model->getByOne([ 'android_id' => $request->android_id ]);
if ($bot_lead === false) {
    $response['status'] = 404;
    $response['message'] = "Bot lead not found";
    echo json_encode($response);
    exit;
}
else {
    $data = [];
    if ( !$bot_lead->install_time && $install_time ) {
        $data['install_time'] = $install_time;
    }
    if ( !$bot_lead->install_wait_time && $install_wait_time ) {
        $data['install_wait_time'] = $install_wait_time;
    }
    if ( !$bot_lead->register_time && $register_time ) {
        $data['register_time'] = $register_time;
    }
    if ( !$bot_lead->register_wait_time && $register_wait_time ) {
        $data['register_wait_time'] = $register_wait_time;
    }
    if ($data) {
        $db_res = $model->updateBy($data, [ 'android_id' => $request->android_id ]);
    } else {
        $response['status'] = 200;
        $response['message'] = "No updates";
        echo json_encode($response);
        exit;
    }
}

if ($db_res !== false) {
    $response['status'] = 200;
    $response['message'] = "Data updated successfully";
    echo json_encode($response);
    exit;
}

$response['status'] = 500;
$response['message'] = "Something went wrong";
echo json_encode($response);

?>