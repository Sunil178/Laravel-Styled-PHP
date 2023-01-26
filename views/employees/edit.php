<?php

    if (!isset($employee_id) || $employee_id == '') {
        echo "Error: employee is required";
        exit;
    }
    include_once __DIR__."/../../database/model.php";

    $model = new Model('employees');
    $employee = $model->get($employee_id);

    include_once __DIR__."/store.php";
?>
