<?php
    ob_start();

    include_once __DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."database".DIRECTORY_SEPARATOR."model.php";

    $model = new Model('gameplays');

    $query = "SELECT gameplays.id, employees.name, employees.username, gameplays.emulator_name, gameplays.date, gameplays.rake, gameplays.count FROM gameplays JOIN employees ON employees.id = gameplays.employee_id";
    $gameplays = $model->runQuery($query);
?>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr class="text-nowrap">
                    <th> # </th>
                    <th> Employee Name </th>
                    <th> Emulator Name </th>
                    <th> Date </th>
                    <th> Rake </th>
                    <th> Count </th>
                    <th> Action </th>
                </tr>
            </thead>
            <tbody id="table-body">
                <?php foreach ($gameplays as $index => $gameplay) { ?>
                    <tr>
                        <td> <?php echo ($index + 1) ?> </td>
                        <td> <?php echo $gameplay->name . ' : ' . $gameplay->username ?> </td>
                        <td> <?php echo $gameplay->emulator_name ?> </td>
                        <td> <?php echo $gameplay->date ?> </td>
                        <td> <?php echo $gameplay->rake ?> </td>
                        <td> <?php echo $gameplay->count ?> </td>
                        <td>
                            <a href="../gameplays/edit.php?gameplay_id=<?php echo $gameplay->id ?>" class="btn btn-info btn-sm">Edit</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

<?php
    $customSection = ob_get_clean();

    include_once __DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."layout".DIRECTORY_SEPARATOR."index.php";
?>
