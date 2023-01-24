<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_POST['confirm_password'] != $_POST['password']) {
    echo "Password and confirm password do not match";
    exit;
}

include_once __DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."database".DIRECTORY_SEPARATOR."model.php";

$model = new Model('employees');
$data = [
    'username' => $_POST['username'],
    'name' => $_POST['name'],
    'mobile' => $_POST['mobile'],
    'email' => $_POST['email'],
    'password' => $_POST['password'],
];

if ($_POST['employee_id']) {
    $db_res = $model->update($data, $_POST['employee_id']);
}
else {
    $db_res = $model->create($data);
}

if ($db_res !== false && $db_res > 0) {
    session_write_close();
    header("Location: ../employees");
}
else {
    echo "Something Went Wrong!";
}
?>