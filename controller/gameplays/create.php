<?php
    $model = new Model('employees');
    $employees = $model->getAll();
    $model = new Model('leads');
    $leads = $model->getAll();

    include_once __DIR__."/../../views/gameplays/store.php";
?>
