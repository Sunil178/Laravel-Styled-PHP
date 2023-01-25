<?php
    if (!isset($gameplay_id) || $gameplay_id == '') {
        echo "Error: gameplay id is required";
        exit;
    }
    include_once __DIR__."/../../database/model.php";

    $model = new Model('gameplays');
    $gameplay = $model->get($gameplay_id);

    include_once __DIR__."/store.php";
?>
