<?php

    if (!isset($order_id) || $order_id == '') {
        echo "Error: Order ID is required";
        exit;
    }

    $model = new Model('sims');
    $employee_id = @$employee_id_param ?: $_SESSION['employee_id'];

    include_once __DIR__."/../utils/http.php";
    $result = checkOrder($order_id);

    if ($result !== false) {
        $sms = end($result['sms']);
        $otp = $sms ? $sms['code'] : null;
        $sms_message = $sms ? json_encode($result['sms']) : null;

        $db_res = $model->updateBy([ 'status' => $result['status'], 'sms' => $sms_message, 'otp' => $otp ], [ 'order_id' => $order_id ]);
        if ($db_res === false) {
            echo "Something went wrong database!";
            exit;
        }
    } else {
        echo "Something went wrong with api!";
        exit;
    }

    $query = "SELECT
            sims.id, sims.order_id, sims.phone, sims.price, sims.otp, sims.status, sims.product_id, products.name AS product_name, sims.operator_id, operators.name as operator_name, sims.sim_created_at, sims.expires_at
            FROM sims
            LEFT JOIN products ON products.id = sims.product_id
            LEFT JOIN operators ON operators.id = sims.operator_id
            WHERE sims.order_id = '$order_id'";

    if (!checkAdmin() || @$employee_id_param) {
        $query .= " AND sims.employee_id = '$employee_id'";
    }

    $sim = $model->runQueryOne($query);

    $result = getProfile();
    if ($result !== false) {
        $balance = $result['balance'];
    } else {
        echo "Something went wrong with api!";
        exit;
    }

    include_once __DIR__."/../../views/sims/sim.php";
?>