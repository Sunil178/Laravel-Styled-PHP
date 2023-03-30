<?php
    if (!isset($date)) {
        $date = date('Y-m-d');
    }

    $model = new Model('gameplays');
    $employee_id = $_SESSION['employee_id'];

    $query = "SELECT gameplays.id, employees.name, employees.username, (CASE WHEN leads.id IS NULL THEN gameplays.emulator_name ELSE leads.emulator END) AS emulator_name, date_format(gameplays.created_at, '%Y-%m-%d') AS date, gr.rake, gr.count FROM gameplays JOIN employees ON employees.id = gameplays.employee_id LEFT JOIN ( SELECT gameplay_id, COUNT(gameplay_rakes.id) AS count, SUM(gameplay_rakes.rake) AS rake FROM gameplay_rakes GROUP BY gameplay_id ) gr ON gr.gameplay_id = gameplays.id LEFT JOIN leads ON leads.id = gameplays.lead_id WHERE DATE(gameplays.created_at) = '$date'";

    if (!checkAdmin()) {
        $query .= " AND gameplays.employee_id = '$employee_id'";
    }

    $query .= " ORDER BY gameplays.created_at DESC";
    $gameplays = $model->runQuery($query);

    include_once __DIR__."/../../views/gameplays/index.php";
?>