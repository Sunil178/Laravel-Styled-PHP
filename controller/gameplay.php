<?php

if (!isset($_POST['employee_id']) || $_POST['employee_id'] == '') {
    if (checkAuth(true)) {
        echo "Employee id is required";
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

include_once __DIR__."/../database/model.php";

$date = $_POST['date'] == '' ? NULL : $_POST['date'];

$model = new Model('gameplays');
$data = [
    'employee_id' => $employee_id,
    'emulator_name' => $_POST['emulator_name'],
    'rake' => (double)$_POST['rake'],
    'count' => (int)$_POST['count'],
    'date' => $date,
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