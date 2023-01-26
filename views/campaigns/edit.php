<?php

    if (!isset($campaign_id) || $campaign_id == '') {
        echo "Error: campaign is required";
        exit;
    }
    include_once __DIR__."/../../database/model.php";

    $model = new Model('campaigns');
    $campaign = $model->get($campaign_id);

    include_once __DIR__."/store.php";
?>
