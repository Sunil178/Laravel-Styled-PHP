<?php

if ((!isset($gameplay_id) || $gameplay_id == '')) {
    echo "Gameplay id is required";
    exit;
}

$model = new Model('gameplay_rakes');
$affectRows = $model->deleteBy([ 'gameplay_id' => $gameplay_id ]);

$model = new Model('gameplays');
$affectRows = $model->delete($gameplay_id);

if ($affectRows > 0) {
    header("Location: /gameplays");
} else {
    echo "Something Went Wrong!";
}

?>