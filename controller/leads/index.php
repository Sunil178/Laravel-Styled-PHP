<?php
    if (!isset($date)) {
        $date = date('Y-m-d');
    }
    if (!isset($state_id)) {
        $state_id = '';
    }
    $model = new Model('leads');
    $employee_id = $employee_id_param ?: $_SESSION['employee_id'];

    $query = "SELECT leads.id, employees.name AS employees_name, employees.username, campaigns.name AS campaign_name, states.name as state_name, leads.type, leads.created_at as lead_date, ld.total_lead_deposit FROM leads JOIN employees ON employees.id = leads.employee_id LEFT JOIN campaigns ON campaigns.id = leads.campaign_id LEFT JOIN states ON states.id = leads.state_id LEFT JOIN ( SELECT lead_id, SUM(lead_deposits.amount) AS total_lead_deposit FROM lead_deposits GROUP BY lead_id ) ld ON ld.lead_id = leads.id WHERE DATE(leads.created_at) = '$date'";

    if (!checkAdmin() || $employee_id_param) {
        $query .= " AND leads.employee_id = '$employee_id'";
    }
    if ($state_id != '') {
        $query .= " AND leads.state_id = '$state_id'";
    }
    $query .= " ORDER BY lead_date DESC";
    $leads = $model->runQuery($query);

    $model = new Model('payment_methods');
    $payment_methods = $model->getAll();
    $model = new Model('states');
    $states = $model->getAll();
    $model = new Model('employees');
    $employees = $model->getAll();

    include_once __DIR__."/../../views/leads/index.php";
?>