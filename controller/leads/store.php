<?php

if (!isset($_POST['employee_id']) || $_POST['employee_id'] == '') {
    if (checkAuth(true)) {
        echo "Employee is required";
        exit;
    }
    $employee_id = $_SESSION['employee_id'];
} else {
    if (checkAuth(true)) {
        $employee_id = $_POST['employee_id'];
    } else {
        $employee_id = $_SESSION['employee_id'];
    }
}

if (!isset($_POST['campaign_id']) || $_POST['campaign_id'] == '') {
    echo "Campaign is required";
    exit;
}

$type = @$_POST['type'];
if (!isset($type) || $type == '') {
    echo "Lead type is required";
    exit;
}

if (!isset($_POST['state_id']) || $_POST['state_id'] == '') {
    echo "State is required";
    exit;
}

if (!isset($_POST['emulator_name']) || $_POST['emulator_name'] == '') {
    echo "Emulator is required";
    exit;
}

$model = new Model('leads');
$data = [
    'employee_id' => $employee_id,
    'campaign_id' => $_POST['campaign_id'],
    'state_id' => $_POST['state_id'],
    'type' => $type,
    'emulator' => $_POST['emulator_name'],
];
$lead_id = $_POST['lead_id'];

if ($lead_id) {
    $db_res1 = $model->update($data, $lead_id);
}
else {
    $db_res1 = $model->create($data);
    $lead_id = $model->getConnection()->insert_id;
}

if ($type == 1) {
    $lead_deposit_amounts = $_POST['lead_deposit_amounts'];
    $payment_method_ids = $_POST['payment_method_ids'];
    $lead_deposit_ids = $_POST['lead_deposit_ids'];

    $model = new Model('lead_deposits');
    foreach ($lead_deposit_ids as $lead_deposit_id_index => $lead_deposit_id) {
        if ($lead_deposit_amounts[$lead_deposit_id_index] != '' && $payment_method_ids[$lead_deposit_id_index] != '') {
            if ($lead_deposit_id == 0) {
                $db_res2 = $model->create([
                    'lead_id' => $lead_id,
                    'amount' => $lead_deposit_amounts[$lead_deposit_id_index],
                    'payment_method_id' => $payment_method_ids[$lead_deposit_id_index],
                ]);
            }
            else {
                $db_res2 = $model->update([
                    'amount' => $lead_deposit_amounts[$lead_deposit_id_index],
                    'payment_method_id' => $payment_method_ids[$lead_deposit_id_index],
                ], $lead_deposit_id);
            }
        }
    }
}

if ($db_res1 !== false && $db_res2 !== false) {
    session_write_close();
    header("Location: /leads");
}
else {
    echo "Something Went Wrong!";
}
?>