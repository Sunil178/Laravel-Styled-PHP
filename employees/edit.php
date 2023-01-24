<?php

    if (!isset($_GET['employee_id']) || $_GET['employee_id'] == '') {
        echo "Error: employee id is required";
        exit;
    }
    include_once __DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."database".DIRECTORY_SEPARATOR."model.php";

    $model = new Model('employees');
    $employee = $model->get($_GET['employee_id']);

    include_once __DIR__.DIRECTORY_SEPARATOR."store.php";
?>
