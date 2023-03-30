<?php
    if (!isset($date)) {
        $date = date('Y-m-d');
    }
    if (!isset($state_id)) {
        $state_id = '';
    }
    $model = new Model('targets');
    $employee_id = $_SESSION['employee_id'];

    $query = "SELECT targets.id, employees.name AS employees_name, campaigns.name AS campaigns_name, targets.reg_count, targets.dep_count, SUM(extra_deposits.count), reg_states.name as reg_state, dep_states.name as dep_state FROM targets JOIN employees ON employees.id = targets.employee_id JOIN campaigns ON campaigns.id = targets.campaign_id JOIN extra_deposits ON extra_deposits.target_id = targets.id JOIN states reg_states ON reg_states.id = targets.reg_state_id JOIN states dep_states ON dep_states.id = targets.dep_state_id WHERE DATE(targets.created_at) = '$date'";

    if (!checkAdmin()) {
        $query .= " AND targets.employee_id = '$employee_id'";
    }

    $query .= " GROUP BY extra_deposits.target_id ORDER BY targets.created_at DESC";
    $targets = $model->runQuery($query);

    $model = new Model('states');
    $states = $model->getAll();

    include_once __DIR__."/../../views/targets/index.php";
?>