<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_POST['employee_id'])) {
    echo "Employee id is required";
    exit;
}

include_once __DIR__."/../database/model.php";

$model = new Model('gameplays');
$data = [
    'employee_id' => $_POST['employee_id'],
    'emulator_name' => $_POST['emulator_name'],
    'date' => $_POST['date'],
    'rake' => $_POST['rake'],
    'count' => $_POST['count'],
];

if ($_POST['gameplay_id']) {
    $db_res = $model->update($data, $_POST['gameplay_id']);
}
else {
    $db_res = $model->create($data);
}

if ($db_res !== false && $db_res > 0) {
    session_write_close();
    header("Location: /gameplays");
}
else {
    echo "Something Went Wrong!";
}
?>