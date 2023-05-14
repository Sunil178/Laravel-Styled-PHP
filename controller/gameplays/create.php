<?php
    $model = new Model('employees');
    $employees = $model->getAll();

    include_once __DIR__."/../../views/gameplays/store.php";
?>
