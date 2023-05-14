<?php
    if (!isset($date)) {
        $date = date('Y-m-d');
    }

    $model = new Model('gameplays');
    $employee_id = @$employee_id_param ?: $_SESSION['employee_id'];

    $query = "SELECT gameplays.id, employees.name, employees.username, (CASE WHEN leads.id IS NULL THEN gameplays.emulator_name ELSE leads.emulator END) AS emulator_name, gameplays.created_at as gameplays_date, gr.rake, gr.count FROM gameplays JOIN employees ON employees.id = gameplays.employee_id LEFT JOIN ( SELECT gameplay_id, COUNT(gameplay_rakes.id) AS count, SUM(gameplay_rakes.rake) AS rake FROM gameplay_rakes GROUP BY gameplay_id ) gr ON gr.gameplay_id = gameplays.id LEFT JOIN leads ON leads.id = gameplays.lead_id WHERE DATE(gameplays.created_at) = '$date'";

    if (!checkAdmin() || @$employee_id_param) {
        $query .= " AND gameplays.employee_id = '$employee_id'";
    }

    $query .= " ORDER BY gameplays.created_at DESC";
    $gameplays = $model->runQuery($query);

    $model = new Model('employees');
    $employees = $model->getAll();

    include_once __DIR__."/../../views/gameplays/index.php";
?>