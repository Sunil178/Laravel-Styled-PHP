<?php

if (!isset($_POST['username']) || !isset($_POST['password'])) {
    echo "Username or password missing";
    exit;
}

$model = new Model('employees');
$username = $_POST['username'];
$password = $_POST['password'];
$query = "SELECT id, name FROM employees WHERE (username = '$username' OR email = '$username') AND password = '$password'";
$employee = $model->runQueryOne($query);

if (get_object_vars($employee) != []) {
    $_SESSION["employee_id"] = $employee->id;
    $_SESSION["employee_name"] = $employee->name;
    session_write_close();
    header("Location: /home");
}
else {
    echo "Something Went Wrong!";
}
?>
