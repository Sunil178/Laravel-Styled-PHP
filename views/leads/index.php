<?php
    ob_start();

    include_once __DIR__."/../../database/model.php";

    $model = new Model('leads');

    $query = "SELECT leads.id, employees.name AS employees_name, employees.username, campaigns.name AS campaign_name, leads.type, leads.state, leads.count, leads.date FROM leads JOIN employees ON employees.id = leads.employee_id JOIN campaigns ON campaigns.id = leads.campaign_id";
    $leads = $model->runQuery($query);
?>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr class="text-nowrap">
                    <th> # </th>
                    <th> Employee Name </th>
                    <th> Campaign Name </th>
                    <th> Type </th>
                    <th> State </th>
                    <th> Count </th>
                    <th> Date </th>
                    <th> Action </th>
                </tr>
            </thead>
            <tbody id="table-body">
                <?php foreach ($leads as $index => $lead) { ?>
                    <tr>
                        <td> <?php echo ($index + 1) ?> </td>
                        <td> <?php echo $lead->employees_name . ' : ' . $lead->username ?> </td>
                        <td> <?php echo $lead->campaign_name ?> </td>
                        <td> <?php echo $lead->type ?> </td>
                        <td> <?php echo $lead->state ?> </td>
                        <td> <?php echo $lead->count ?> </td>
                        <td> <?php echo $lead->date ?> </td>
                        <td>
                            <a href="/leads/edit.php?lead_id=<?php echo $lead->id ?>" class="btn btn-info btn-sm">Edit</a>
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