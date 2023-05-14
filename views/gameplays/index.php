
<?php ob_start(); ?>

    <style>
        input[name=date] {
            width: initial;
            display: initial;
        }
    </style>

<?php $customStyle = ob_get_clean(); ?>

<?php ob_start(); ?>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr class="text-nowrap">
                    <th> # </th>
                    <?php if (checkAuth(true)) { ?>
                        <th> Employee </th>
                    <?php } ?>
                    <th> Emulator </th>
                    <th> Count </th>
                    <th> <i class='bx bx-rupee mt-0'></i> Rake </th>
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
                            <td> <?php echo $gameplay->name ?> </td>
                        <?php } ?>
                        <td> <?php echo $gameplay->emulator_name ?> </td>
                        <td> <?php echo (int) $gameplay->count ?> </td>
                        <td> <i class='bx bx-rupee mt-0'></i> <?php echo (int) $gameplay->rake ?> </td>
                        <td> <?php echo $gameplay->gameplays_date ?> </td>
                        <td>
                            <a href="/gameplays/edit/<?php echo $gameplay->id ?>" class="btn btn-info btn-sm">Edit</a>
                            <a href="#" gameplay-id="<?php echo $gameplay->id ?>" class="btn btn-danger btn-sm delete-gameplay">Delete</a>
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
            <?php if (checkAuth(true)) { ?>
                <li class="nav-item lh-1 d-flex flex-row me-3">
                    <span class="mt-2 me-2">Employee:</span>
                    <select name="employee_id" class="form-select" required>
                            <option value=""> -- select employee -- </option>
                            <?php foreach ($employees as $employee) { ?>
                                <option <?php echo ($employee_id == $employee->id) ? 'selected' : ''; ?> value="<?php echo $employee->id; ?>"><?php echo $employee->name; ?></option>
                            <?php } ?>
                    </select>

                </li>
            <?php } ?>
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
    <?php if (checkAuth(true)) { ?>
        $('select[name="employee_id"]').on('change', function (event) {
            date = $('input[name="date"]').val();
            window.location = "/gameplays/" + date + "/" + this.value;
        });
    <?php } ?>

    $('.delete-gameplay').on('click', function (event) {
        gameplay_id = $(this).attr('gameplay-id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
            if (result.isConfirmed) {
                window.location = "/gameplays/delete/" + gameplay_id;
            }
		});
    });

</script>

<?php
    $customScript = ob_get_clean();
    include_once __DIR__."/../../layout/index.php";
?>
