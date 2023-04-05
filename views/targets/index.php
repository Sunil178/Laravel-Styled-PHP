<?php ob_start(); ?>
    <style>
        input[name=date] {
            width: initial;
            display: initial;
        }

        th {
            font-weight: bolder;
            font-size: small !important;
        }

        #totals {
            table-layout: fixed;
            width: 25vw;
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
                        <th> Employee Name </th>
                    <?php } ?>
                    <th> Campaign Name </th>
                    <th> Reg State </th>
                    <th> Reg Count</th>
                    <th> Reg Completed </th>
                    <th> Reg Pending </th>
                    <th> Dep State </th>
                    <th> Dep + Extra = Count </th>
                    <th> Dep Completed </th>
                    <th> Dep Pending </th>
                    <th> Action </th>
                </tr>
            </thead>
            <tbody id="table-body">
                <?php $registration_target = $registration_completed = $registration_pending = $deposit_target = $deposit_completed = $deposit_pending = $deposit_amount = 0; ?>
                <?php foreach ($targets as $index => $target) { ?>
                    <tr>
                        <td> <?php echo ($index + 1) ?> </td>
                        <?php if (checkAuth(true)) { ?>
                            <td> <?php echo $target->employees_name ?> </td>
                        <?php } ?>
                        <td> <?php echo $target->campaign_name ?> </td>
                        <td> <?php echo $target->reg_state ?? '-' ?> </td>
                        <td> <?php echo (int)$target->reg_count ?> </td>
                        <td> <?php echo (int)$target->reg_made_count ?> </td>
                        <td> <?php echo ((int)$target->reg_count - (int)$target->reg_made_count) ?> </td>
                        <td> <?php echo $target->dep_state ?? '-' ?> </td>
                        <td>
                            <?php
                                $total_deposits = (int)$target->dep_count + (int)$target->extra_deposit;
                                echo (int)$target->dep_count . '  +    ' . (int)$target->extra_deposit . ' =   <b>' . $total_deposits . '</b>';
                            ?>
                        </td>
                        <td> <?php echo (int)$target->dep_made_count ?> </td>
                        <td> <?php echo ($total_deposits - (int)$target->dep_made_count) ?> </td>
                        <td>
                            <a href="/targets/view/<?php echo $target->id ?>" class="btn btn-info btn-sm">View</a>
                        <?php if (checkAuth(true)) { ?>
                            <a href="/targets/edit/<?php echo $target->id ?>" class="btn btn-primary btn-sm">Edit</a>
                        <?php } ?>
                        </td>
                    </tr>
                    <?php
                        $registration_target += (int)$target->reg_count;
                        $registration_completed += (int)$target->reg_made_count;
                        $registration_pending += (int)$target->reg_count - (int)$target->reg_made_count;

                        $deposit_target += $total_deposits;
                        $deposit_completed += (int)$target->dep_made_count;
                        $deposit_pending += $total_deposits - (int)$target->dep_made_count;
                    ?>
                <?php } ?>
            </tbody>
        </table>
    </div>

<?php $customSection = ob_get_clean(); ?>

<?php ob_start(); ?>

    <div class="navbar-nav-left w-100">
        <ul class="navbar-nav align-items-center ms-auto">
            <li class="nav-item lh-1 me-3">
                <i class='bx bxs-calendar mt-0'></i>
                <span class="mt-2 me-2">Date:</span>
                <input type="date" class="form-control" name="date" value="<?php echo $date; ?>">
            </li>
            <li class="nav-item lh-1 d-flex flex-row me-3">
                <span class="mt-2 me-2">State:</span>
                <select name="state_id" class="form-select" required>
                        <option value=""> -- select state -- </option>
                        <?php foreach ($states as $state) { ?>
                            <option <?php echo ($state_id == $state->id) ? 'selected' : ''; ?> value="<?php echo $state->id; ?>"><?php echo $state->code . ' : ' . $state->name; ?></option>
                        <?php } ?>
                </select>
            </li>
            <li class="nav-item lh-1 me-3">
                <table id="totals">
                    <tr>
                        <td> <b>Registrations:</b> </td>
                        <td> <?php echo "Target: $registration_target" ?> </td>
                        <td> <?php echo "Completed: $registration_completed" ?> </td>
                        <td> <?php echo "Pending: $registration_pending" ?> </td>
                    </tr>
                    <tr>
                        <td> <b>Deposits:</b> </td>
                        <td> <?php echo "Target: $deposit_target" ?> </td>
                        <td> <?php echo "Completed: $deposit_completed" ?> </td>
                        <td> <?php echo "Pending: $deposit_pending" ?> </td>
                    </tr>
                </table>
            </li>
        </ul>
    </div>

<?php $customNavbar = ob_get_clean(); ?>

<?php ob_start(); ?>

<script>
    $('input[name="date"]').on('change', function (event) {
        window.location = "/targets/" + this.value;
    });
    $('select[name="state_id"]').on('change', function (event) {
        date = $('input[name="date"]').val();
        window.location = "/targets/" + date + "/" + this.value;
    });
</script>

<?php
    $customScript = ob_get_clean();
    include_once __DIR__."/../../layout/index.php";
?>
