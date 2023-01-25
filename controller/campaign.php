<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once __DIR__."/../database/model.php";

$model = new Model('campaigns');
$data = [ 'name' => $_POST['name'] ];

if ($_POST['campaign_id']) {
    $db_res = $model->update($data, $_POST['campaign_id']);
}
else {
    $db_res = $model->create($data);
}

if ($db_res !== false && $db_res > 0) {
    session_write_close();
    header("Location: /campaigns");
}
else {
    echo "Something Went Wrong!";
}
?>