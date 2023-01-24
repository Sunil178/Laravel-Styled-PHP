
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
?>

<?php

    if (!isset($_GET['gameplay_id']) || $_GET['gameplay_id'] == '') {
        echo "Error: gameplay id is required";
        exit;
    }
    include_once __DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."database".DIRECTORY_SEPARATOR."model.php";

    $model = new Model('gameplays');
    $gameplay = $model->get($_GET['gameplay_id']);

    include_once __DIR__.DIRECTORY_SEPARATOR."store.php";
?>
