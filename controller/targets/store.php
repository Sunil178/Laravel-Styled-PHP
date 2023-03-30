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

if (!isset($_POST['reg_state_id']) || $_POST['reg_state_id'] == '') {
    echo "Registration state is required";
    exit;
}

if (!isset($_POST['reg_count']) || $_POST['reg_count'] == '') {
    echo "Registration count is required";
    exit;
}

if (!isset($_POST['dep_state_id']) || $_POST['dep_state_id'] == '') {
    echo "Deposit state is required";
    exit;
}

if (!isset($_POST['dep_count']) || $_POST['dep_count'] == '') {
    echo "Deposit count is required";
    exit;
}

$model = new Model('targets');
$data = [
    'employee_id' => $employee_id,
    'campaign_id' => $_POST['campaign_id'],
    'reg_state_id' => $_POST['reg_state_id'],
    'reg_count' => $_POST['reg_count'],
    'dep_state_id' => $_POST['dep_state_id'],
    'dep_count' => $_POST['dep_count'],
];
$target_id = $_POST['target_id'];

if ($target_id) {
    $db_res1 = $model->update($data, $target_id);
}
else {
    $db_res1 = $model->create($data);
    $target_id = $model->getConnection()->insert_id;
}

$extra_deposit_counts = $_POST['extra_deposit_counts'];
$day_ids = $_POST['day_ids'];
$extra_deposit_ids = $_POST['extra_deposit_ids'] ?: [];

$model = new Model('extra_deposits');
foreach ($extra_deposit_ids as $extra_deposit_id_index => $extra_deposit_id) {
    if ($extra_deposit_counts[$extra_deposit_id_index] != '' && $day_ids[$extra_deposit_id_index] != '') {
        if ($extra_deposit_id == 0) {
            $db_res2 = $model->create([
                'target_id' => $target_id,
                'count' => $extra_deposit_counts[$extra_deposit_id_index],
                'retention_day_id' => $day_ids[$extra_deposit_id_index],
            ]);
        }
        else {
            $db_res2 = $model->update([
                'count' => $extra_deposit_counts[$extra_deposit_id_index],
                'retention_day_id' => $day_ids[$extra_deposit_id_index],
            ], $extra_deposit_id);
        }
    }
}

if ($db_res1 !== false && $db_res2 !== false) {
    session_write_close();
    header("Location: /targets");
}
else {
    echo "Something Went Wrong!";
}
?>