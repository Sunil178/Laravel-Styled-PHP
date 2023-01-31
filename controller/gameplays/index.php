<?php
    if (!isset($date)) {
        $date = date('Y-m-d');
    }

    include_once __DIR__."/../../database/model.php";

    $model = new Model('gameplays');

    $employee_id = $_SESSION['employee_id'];

    $query = "SELECT gameplays.id, employees.name, employees.username, gameplays.emulator_name, gameplays.date, gr.rake, gr.count FROM gameplays JOIN employees ON employees.id = gameplays.employee_id LEFT JOIN ( SELECT gameplay_id, COUNT(gameplay_rakes.id) AS count, SUM(gameplay_rakes.rake) AS rake FROM gameplay_rakes GROUP BY gameplay_id ) gr ON gr.gameplay_id = gameplays.id WHERE DATE(gameplays.created_at) = '$date'";

    if (!checkAdmin()) {
        $query .= " AND gameplays.employee_id = '$employee_id'";
    }

    $query .= " ORDER BY gameplays.date DESC";
    $gameplays = $model->runQuery($query);

    include_once __DIR__."/../../views/gameplays/index.php";
?>