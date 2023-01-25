<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_POST['employee_id'])) {
    echo "Employee id is required";
    exit;
}

if (!isset($_POST['campaign_id'])) {
    echo "Campaign id is required";
    exit;
}

include_once __DIR__."/../database/model.php";

$model = new Model('leads');
$data = [
    'employee_id' => $_POST['employee_id'],
    'campaign_id' => $_POST['campaign_id'],
    'type' => $_POST['type'],
    'state' => $_POST['state'],
    'count' => $_POST['count'],
    'date' => $_POST['date'],
];

if ($_POST['lead_id']) {
    $db_res = $model->update($data, $_POST['lead_id']);
}
else {
    $db_res = $model->create($data);
}

if ($db_res !== false && $db_res > 0) {
    session_write_close();
    header("Location: ../leads");
}
else {
    echo "Something Went Wrong!";
}
?>