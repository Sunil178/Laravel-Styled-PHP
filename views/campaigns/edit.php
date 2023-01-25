
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
?>

<?php

    if (!isset($_GET['campaign_id']) || $_GET['campaign_id'] == '') {
        echo "Error: campaign id is required";
        exit;
    }
    include_once __DIR__."/../../database/model.php";

    $model = new Model('campaigns');
    $campaign = $model->get($_GET['campaign_id']);

    include_once __DIR__."/store.php";
?>
