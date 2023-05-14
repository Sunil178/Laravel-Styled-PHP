<?php
    $model = new Model('employees');
    $employees = $model->getAll();

    $model = new Model('campaigns');
    $campaigns = $model->getAll();

    $model = new Model('states');
    $states = $model->getAll();

    $model = new Model('payment_methods');
    $payment_methods = $model->getAll();

    $model = new Model('retention_days');
    $retention_days = $model->getAll();

    include_once __DIR__."/../../views/leads/store.php";
?>
