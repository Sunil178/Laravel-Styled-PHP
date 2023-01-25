<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_POST['username']) || !isset($_POST['password'])) {
    echo "Username or password missing";
    exit;
}

include_once __DIR__."/../database/model.php";

$model = new Model('employees');
$username = $_POST['username'];
$password = $_POST['password'];
$query = "SELECT id FROM employees WHERE (username = '$username' OR email = '$username') AND password = '$password'";
$employee = $model->runQueryOne($query);

if (get_object_vars($employee) != []) {
    session_write_close();
    header("Location: /home");
}
else {
    echo "Something Went Wrong!";
}
?>