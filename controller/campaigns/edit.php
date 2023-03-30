<?php

    if (!isset($campaign_id) || $campaign_id == '') {
        echo "Error: campaign is required";
        exit;
    }

    $model = new Model('campaigns');
    $campaign = $model->get($campaign_id);

    include_once __DIR__."/create.php";
?>
