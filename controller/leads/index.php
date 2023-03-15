<?php
    if (!isset($date)) {
        $date = date('Y-m-d');
    }

    $model = new Model('leads');
    $employee_id = $_SESSION['employee_id'];

    /* $query = "SELECT leads.id, employees.name AS employees_name, employees.username, campaigns.name AS campaign_name, states.name as state_name, leads.type, leads.state, (CASE WHEN leads.count IS NULL THEN le.count ELSE leads.count END) AS count, lead_date FROM leads JOIN employees ON employees.id = leads.employee_id LEFT JOIN campaigns ON campaigns.id = leads.campaign_id LEFT JOIN states ON states.id = leads.state_id LEFT JOIN ( SELECT lead_id, COUNT(emulators.id) AS count FROM emulators GROUP BY lead_id ) le ON le.lead_id = leads.id WHERE DATE(lead_date) = '$date'"; */

    $query = "SELECT leads.id, employees.name AS employees_name, employees.username, campaigns.name AS campaign_name, states.name as state_name, leads.type, leads.created_at as lead_date, ld.total_lead_deposit FROM leads JOIN employees ON employees.id = leads.employee_id LEFT JOIN campaigns ON campaigns.id = leads.campaign_id LEFT JOIN states ON states.id = leads.state_id LEFT JOIN ( SELECT lead_id, SUM(lead_deposits.amount) AS total_lead_deposit FROM lead_deposits GROUP BY lead_id ) ld ON ld.lead_id = leads.id WHERE DATE(leads.created_at) = '$date'";

    if (!checkAdmin()) {
        $query .= " AND leads.employee_id = '$employee_id'";
    }
    $query .= " ORDER BY lead_date DESC";
    $leads = $model->runQuery($query);

    $model = new Model('payment_methods');
    $payment_methods = $model->getAll();

    include_once __DIR__."/../../views/leads/index.php";
?>