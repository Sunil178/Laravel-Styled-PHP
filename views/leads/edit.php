<?php

    if (!isset($lead_id) || $lead_id == '') {
        echo "Error: lead id is required";
        exit;
    }
    include_once __DIR__."/../../database/model.php";

    $model = new Model('leads');
    $lead = $model->get($lead_id);

    include_once __DIR__."/store.php";
?>
