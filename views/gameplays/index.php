
<?php ob_start(); ?>

    <style>
        input[name=date] {
            width: initial;
            display: initial;
        }
    </style>

<?php $customStyle = ob_get_clean(); ?>

<?php
    ob_start();

    if (!isset($date)) {
        $date = date('Y-m-d');
    }

    include_once __DIR__."/../../database/model.php";

    $model = new Model('gameplays');

    $employee_id = $_SESSION['employee_id'];

    $query = "SELECT gameplays.id, employees.name, employees.username, gameplays.emulator_name, gameplays.date, gr.rake, gr.count FROM gameplays JOIN employees ON employees.id = gameplays.employee_id LEFT JOIN ( SELECT gameplay_id, COUNT(gameplay_rakes.id) AS count, SUM(gameplay_rakes.rake) AS rake FROM gameplay_rakes GROUP BY gameplay_id ) gr ON gr.gameplay_id = gameplays.id WHERE gameplays.date = '$date'";

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
                    <th> Count </th>
                    <th> Rake </th>
                    <th> Date </th>
                    <th> Action </th>
                </tr>
            </thead>
            <tbody id="table-body">
                <?php $total_rake = 0; ?>
                <?php foreach ($gameplays as $index => $gameplay) { ?>
                    <tr>
                        <td> <?php echo ($index + 1) ?> </td>
                        <?php if (checkAuth(true)) { ?>
                            <td> <?php echo $gameplay->name . ' : ' . $gameplay->username ?> </td>
                        <?php } ?>
                        <td> <?php echo $gameplay->emulator_name ?> </td>
                        <td> <?php echo $gameplay->count ?> </td>
                        <td> <?php echo $gameplay->rake ?> </td>
                        <td> <?php echo $gameplay->date ?> </td>
                        <td>
                            <a href="/gameplays/edit/<?php echo $gameplay->id ?>" class="btn btn-info btn-sm">Edit</a>
                        </td>
                    </tr>
                    <?php $total_rake += $gameplay->rake; ?>
                <?php } ?>
            </tbody>
        </table>
    </div>

<?php $customSection = ob_get_clean(); ?>

<?php ob_start(); ?>

    <div class="navbar-nav-left w-75">
        <ul class="navbar-nav align-items-center ms-auto">
            <li class="nav-item lh-1 me-4">
                <i class='bx bxs-calendar mt-0'></i>
                Filter Date:&nbsp;&nbsp;&nbsp;<input type="date" class="form-control" name="date" value="<?php echo $date; ?>">
            </li>
            <li class="nav-item lh-1 me-4">
                <span>Total Rake: <b><i class='bx bx-rupee mt-0'></i><?php echo $total_rake; ?></b></span>
            </li>
        </ul>
    </div>

<?php $customNavbar = ob_get_clean(); ?>

<?php ob_start(); ?>

<script>
    $('input[name="date"]').on('change', function (event) {
        window.location = "/gameplays/" + this.value;
    });
</script>

<?php
    $customScript = ob_get_clean();
    include_once __DIR__."/../../layout/index.php";
?>
