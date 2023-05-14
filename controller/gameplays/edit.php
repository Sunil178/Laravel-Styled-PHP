<?php
    if (!isset($gameplay_id) || $gameplay_id == '') {
        echo "Error: gameplay is required";
        exit;
    }

    $model = new Model('gameplays');
    $query = "SELECT gameplays.*, leads.emulator FROM gameplays LEFT JOIN leads ON leads.id = gameplays.lead_id WHERE gameplays.id = $gameplay_id";
    $gameplay = $model->runQuery($query);

    if (count($gameplay) > 0) {
        $gameplay = $gameplay[0];
    } else {
        header("Location: /404");
        exit;
    }

    $model = new Model('gameplay_rakes');
    $gameplay_rakes = $model->getBy([ 'gameplay_id' => $gameplay_id ]);

    include_once __DIR__."/create.php";
?>
