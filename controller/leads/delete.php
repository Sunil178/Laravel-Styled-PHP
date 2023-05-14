<?php

if ((!isset($lead_id) || $lead_id == '')) {
    echo "Lead id is required";
    exit;
}

$model = new Model('lead_deposits');
$affectRows = $model->deleteBy([ 'lead_id' => $lead_id ]);

$model = new Model('leads');
$affectRows = $model->delete($lead_id);

if ($affectRows > 0) {
    header("Location: /leads");
} else {
    echo "Something Went Wrong!";
}

?>