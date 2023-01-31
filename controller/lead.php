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

$date = @$_POST['date'];
if (!isset($date) || $date == '') {
    echo "Date is required";
    exit;
}

include_once __DIR__."/../database/model.php";

$count = $_POST['count'] == '' ? NULL : ($type == 1 ? NULL : $_POST['count']);

$model = new Model('leads');
$data = [
    'employee_id' => $employee_id,
    'campaign_id' => $_POST['campaign_id'],
    'type' => $type,
    'state_id' => $_POST['state_id'],
    'count' => $count,
    'date' => $date,
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
    $emulators = $_POST['emulators'];
    $emulator_ids = $_POST['emulator_ids'];

    $model = new Model('emulators');
    foreach ($emulator_ids as $emulator_id_index => $emulator_id) {
        if ($emulators[$emulator_id_index] != '') {
            if ($emulator_id == 0) {
                $db_res2 = $model->create([
                    'lead_id' => $lead_id,
                    'name' => $emulators[$emulator_id_index],
                ]);
            }
            else {
                $db_res2 = $model->update([
                    'name' => $emulators[$emulator_id_index],
                ], $emulator_id);
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