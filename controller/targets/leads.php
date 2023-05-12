<?php
    if (!isset($date)) {
        $date = date('Y-m-d');
    }
    if (!isset($state_id)) {
        $state_id = '';
    }
    $model = new Model('leads');
    $employee_id = $_SESSION['employee_id'];

    $query = "SELECT
    
employees.name employee_name, campaigns.name campaign_name,
(CASE WHEN leads.type = '0' THEN states.name ELSE '-' END) reg_state,
(CASE WHEN leads.type = '1' THEN states.name ELSE '-' END) dep_state,
SUM(CASE WHEN leads.type = '0' THEN 1 ELSE 0 END) reg_made_count,
SUM(CASE WHEN leads.type = '0' AND tracked = '0' THEN 1 ELSE 0 END) reg_made_tracked_count,
SUM(CASE WHEN leads.type = '1' THEN 1 ELSE 0 END) dep_made_count,
SUM(CASE WHEN leads.type = '1' AND tracked = '0' THEN 1 ELSE 0 END) dep_made_tracked_count
FROM leads
LEFT JOIN states ON states.id = leads.state_id
LEFT JOIN employees ON employees.id = leads.employee_id
LEFT JOIN campaigns ON campaigns.id = leads.campaign_id
WHERE DATE(leads.created_at) = '$date'";

    if (!checkAdmin()) {
        $query .= " AND leads.employee_id = '$employee_id'";
    }

    $query .= " GROUP BY leads.employee_id, leads.campaign_id, leads.state_id ORDER BY employee_name";
    $targets = $model->runQuery($query);

    $model = new Model('states');
    $states = $model->getAll();

    include_once __DIR__."/../../views/targets/leads.php";
?>