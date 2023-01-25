
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
?>

<?php

    if (!isset($_GET['lead_id']) || $_GET['lead_id'] == '') {
        echo "Error: lead id is required";
        exit;
    }
    include_once __DIR__."/../../database/model.php";

    $model = new Model('leads');
    $lead = $model->get($_GET['lead_id']);

    include_once __DIR__."/store.php";
?>
