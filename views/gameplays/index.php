<?php
    ob_start();

    include_once __DIR__."/../../database/model.php";

    $model = new Model('gameplays');

    $employee_id = $_SESSION['employee_id'];

    $query = "SELECT gameplays.id, employees.name, employees.username, gameplays.emulator_name, gameplays.date, gameplays.rake, gameplays.count FROM gameplays JOIN employees ON employees.id = gameplays.employee_id";
    if (!checkAdmin()) {
        $query .= " WHERE gameplays.employee_id = '$employee_id'";
    }
    $query .= " ORDER BY gameplays.date DESC";
    $gameplays = $model->runQuery($query);
?>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr class="text-nowrap">
                    <th> # </th>
                    <?php if (checkAuth(true)) { ?>
                        <th> Employee Name </th>
                    <?php } ?>
                    <th> Emulator Name </th>
                    <th> Rake </th>
                    <th> Count </th>
                    <th> Date </th>
                    <th> Action </th>
                </tr>
            </thead>
            <tbody id="table-body">
                <?php foreach ($gameplays as $index => $gameplay) { ?>
                    <tr>
                        <td> <?php echo ($index + 1) ?> </td>
                        <?php if (checkAuth(true)) { ?>
                            <td> <?php echo $gameplay->name . ' : ' . $gameplay->username ?> </td>
                        <?php } ?>
                        <td> <?php echo $gameplay->emulator_name ?> </td>
                        <td> <?php echo $gameplay->rake ?> </td>
                        <td> <?php echo $gameplay->count ?> </td>
                        <td> <?php echo $gameplay->date ?> </td>
                        <td>
                            <a href="/gameplays/edit/<?php echo $gameplay->id ?>" class="btn btn-info btn-sm">Edit</a>
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
