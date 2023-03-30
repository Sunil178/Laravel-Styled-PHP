<?php

    if (!isset($target_id) || $target_id == '') {
        echo "Error: target is required";
        exit;
    }

    $model = new Model('targets');
    $target = $model->get($target_id);

    $model = new Model('extra_deposits');
    $extra_deposits = $model->getBy([ 'target_id' => $target_id ]);

    include_once __DIR__."/create.php";
?>
