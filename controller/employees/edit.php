<?php

    if (!isset($employee_id) || $employee_id == '') {
        echo "Error: employee is required";
        exit;
    }

    $model = new Model('employees');
    $employee = $model->get($employee_id);

    include_once __DIR__."/create.php";
?>
