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

if (!isset($_POST['type']) || $_POST['type'] == '') {
    echo "Lead type is required";
    exit;
}

if (!isset($_POST['state_id']) || $_POST['state_id'] == '') {
    echo "State is required";
    exit;
}

include_once __DIR__."/../database/model.php";

$date = $_POST['date'] == '' ? NULL : $_POST['date'];

$model = new Model('leads');
$data = [
    'employee_id' => $employee_id,
    'campaign_id' => $_POST['campaign_id'],
    'type' => $_POST['type'],
    'state_id' => $_POST['state_id'],
    'count' => (int)$_POST['count'],
    'date' => $date,
];

if ($_POST['lead_id']) {
    $db_res = $model->update($data, $_POST['lead_id']);
}
else {
    $db_res = $model->create($data);
}

if ($db_res !== false && $db_res > 0) {
    session_write_close();
    header("Location: /leads");
}
else {
    echo "Something Went Wrong!";
}
?>