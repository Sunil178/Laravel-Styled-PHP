<?php
    ob_start();

    include_once __DIR__."/../../database/model.php";

    $model = new Model('leads');

    $employee_id = $_SESSION['employee_id'];

    $query = "SELECT leads.id, employees.name AS employees_name, employees.username, campaigns.name AS campaign_name, states.name as state_name, leads.type, leads.state, (CASE WHEN leads.count IS NULL THEN le.count ELSE leads.count END) AS count, leads.date FROM leads JOIN employees ON employees.id = leads.employee_id LEFT JOIN campaigns ON campaigns.id = leads.campaign_id LEFT JOIN states ON states.id = leads.state_id LEFT JOIN ( SELECT lead_id, COUNT(emulators.id) AS count FROM emulators GROUP BY lead_id ) le ON le.lead_id = leads.id ";

    if (!checkAdmin()) {
        $query .= " WHERE leads.employee_id = '$employee_id'";
    }
    $query .= " ORDER BY leads.date DESC";
    $leads = $model->runQuery($query);
?>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr class="text-nowrap">
                    <th> # </th>
                    <?php if (checkAuth(true)) { ?>
                        <th> Employee Name </th>
                    <?php } ?>
                    <th> Campaign Name </th>
                    <th> State </th>
                    <th> Type </th>
                    <th> Count </th>
                    <th> Date </th>
                    <th> Action </th>
                </tr>
            </thead>
            <tbody id="table-body">
                <?php foreach ($leads as $index => $lead) { ?>
                    <tr>
                        <td> <?php echo ($index + 1) ?> </td>
                        <?php if (checkAuth(true)) { ?>
                            <td> <?php echo $lead->employees_name . ' : ' . $lead->username ?> </td>
                        <?php } ?>
                        <td> <?php echo $lead->campaign_name ?> </td>
                        <td> <?php echo $lead->state_name ?> </td>
                        <td> <?php echo ($lead->type == 0 ? 'Registration' : 'Deposit') ?> </td>
                        <td> <?php echo $lead->count ?> </td>
                        <td> <?php echo $lead->date ?> </td>
                        <td>
                            <a href="/leads/edit/<?php echo $lead->id ?>" class="btn btn-info btn-sm">Edit</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

<?php
    $customSection = ob_get_clean();

    include_once __DIR__."/../../layout/index.php";
?>
