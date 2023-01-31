<?php

    if (!isset($lead_id) || $lead_id == '') {
        echo "Error: lead is required";
        exit;
    }
    include_once __DIR__."/../../database/model.php";

    $model = new Model('leads');
    $lead = $model->get($lead_id);

    $model = new Model('emulators');
    $lead_emulators = $model->getBy([ 'lead_id' => $lead_id ]);

    include_once __DIR__."/store.php";
?>
