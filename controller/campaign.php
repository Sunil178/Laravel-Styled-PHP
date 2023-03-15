<?php

$model = new Model('campaigns');
$data = [ 'name' => $_POST['name'] ];

if ($_POST['campaign_id']) {
    $db_res = $model->update($data, $_POST['campaign_id']);
}
else {
    $db_res = $model->create($data);
}

if ($db_res !== false) {
    session_write_close();
    header("Location: /acampaigns");
}
else {
    echo "Something Went Wrong!";
}
?>