<?php
    if (!isset($date)) {
        $date = date('Y-m-d');
    }
    if (!isset($state_id)) {
        $state_id = '';
    }
    $model = new Model('targets');
    $employee_id = $_SESSION['employee_id'];

    $query = "SELECT
        targets.id, employees.name AS employees_name, campaigns.name AS campaign_name, targets.reg_count, target_reg_leads.reg_made_count, target_reg_tracked_leads.reg_made_tracked_count, targets.dep_count, target_dep_leads.dep_made_count, target_dep_tracked_leads.dep_made_tracked_count, ex_dep.extra_deposit, reg_states.name as reg_state, dep_states.name as dep_state
        FROM targets
        JOIN employees ON employees.id = targets.employee_id
        JOIN campaigns ON campaigns.id = targets.campaign_id
        LEFT JOIN (SELECT SUM(extra_deposits.count) AS extra_deposit, target_id FROM extra_deposits GROUP BY target_id) ex_dep ON ex_dep.target_id = targets.id
        LEFT JOIN states reg_states ON reg_states.id = targets.reg_state_id
        LEFT JOIN states dep_states ON dep_states.id = targets.dep_state_id

        LEFT JOIN (SELECT employee_id, campaign_id, state_id, COUNT(emulator) AS reg_made_count FROM leads WHERE DATE(leads.created_at) = '$date' AND type = '0' GROUP BY employee_id, campaign_id, state_id) target_reg_leads ON target_reg_leads.employee_id = targets.employee_id AND target_reg_leads.campaign_id = targets.campaign_id AND target_reg_leads.state_id = targets.reg_state_id

        LEFT JOIN (SELECT employee_id, campaign_id, state_id, COUNT(emulator) AS reg_made_tracked_count FROM leads WHERE DATE(leads.created_at) = '$date' AND type = '0'  AND tracked = '0' GROUP BY employee_id, campaign_id, state_id) target_reg_tracked_leads ON target_reg_tracked_leads.employee_id = targets.employee_id AND target_reg_tracked_leads.campaign_id = targets.campaign_id AND target_reg_tracked_leads.state_id = targets.reg_state_id

        LEFT JOIN (SELECT employee_id, campaign_id, state_id, COUNT(emulator) AS dep_made_count FROM leads WHERE DATE(leads.created_at) = '$date' AND type = '1' GROUP BY employee_id, campaign_id, state_id) target_dep_leads ON target_dep_leads.employee_id = targets.employee_id AND target_dep_leads.campaign_id = targets.campaign_id AND target_dep_leads.state_id = targets.dep_state_id

        LEFT JOIN (SELECT employee_id, campaign_id, state_id, COUNT(emulator) AS dep_made_tracked_count FROM leads WHERE DATE(leads.created_at) = '$date' AND type = '1'  AND tracked = '0' GROUP BY employee_id, campaign_id, state_id) target_dep_tracked_leads ON target_dep_tracked_leads.employee_id = targets.employee_id AND target_dep_tracked_leads.campaign_id = targets.campaign_id AND target_dep_tracked_leads.state_id = targets.dep_state_id

        WHERE DATE(targets.created_at) = '$date'";

    if (!checkAdmin()) {
        $query .= " AND targets.employee_id = '$employee_id'";
    }

    $query .= " ORDER BY targets.created_at DESC";
    $targets = $model->runQuery($query);

    $model = new Model('states');
    $states = $model->getAll();

    include_once __DIR__."/../../views/targets/index.php";
?>
