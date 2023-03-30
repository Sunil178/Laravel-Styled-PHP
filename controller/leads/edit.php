<?php

    if (!isset($lead_id) || $lead_id == '') {
        echo "Error: lead is required";
        exit;
    }

    $model = new Model('leads');
    $lead = $model->get($lead_id);

    $model = new Model('lead_deposits');
    $lead_deposits = $model->getBy([ 'lead_id' => $lead_id ]);

    include_once __DIR__."/create.php";
?>
