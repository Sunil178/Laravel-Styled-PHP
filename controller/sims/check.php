<?php

if (!isset($order_id) || $order_id == '') {
    echo "Error: Order ID is required";
    exit;
}

$employee_id = $_SESSION['employee_id'];
$model = new Model('sims');
if (!checkAdmin()) {
    $sim = $model->getByOne([ 'order_id' => $order_id, 'employee_id' => $employee_id ]);
    if ((array)$sim == []) {
        echo "Error: Order ID is not generated by you!";
        exit;
    }
}

include_once __DIR__."/../utils/http.php";

$result = checkOrder($order_id);

$response = [ 'status' => 500, 'message' => 'Failed', 'data' => null ];

if ($result !== false) {
    if ($result['status'] == 'RECEIVED') {
        $sms = end($result['sms']);
        $otp = $sms ? $sms['code'] : null;
    
        if ($otp) {
            $response['status'] = 200;
            $response['message'] = 'OTP Received';
        } else {
            $response['status'] = 404;
            $response['message'] = 'No OTP Received';
        }
    } else {
        $otp = '0000';
        $response['status'] = 421;
        $response['message'] = 'Number status changed';
    }
    if ($response['status'] == 200 || $response['status'] == 421) {
        $response['data'] = [ 'status' => $result['status'], 'otp' => $otp ];
        $db_res = $model->updateBy([ 'status' => $result['status'], 'sms' => json_encode($result['sms']), 'otp' => ($otp == '0000' ? null : $otp) ], [ 'order_id' => $order_id ]);
        if ($db_res == false) {
            $response['message'] = 'Failed to update database';
        }
    }
} else {
    $response['message'] = 'Error at api';
}

session_write_close();
echo json_encode($response);

?>
