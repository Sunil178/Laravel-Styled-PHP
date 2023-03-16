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
                        <th> Employee Name </th>
                    <?php } ?>
                    <th> Campaign Name </th>
                    <th> State </th>
                    <th> Type </th>
                    <th> <i class='bx bx-rupee mt-0'></i> Amount </th>
                    <th> Date </th>
                    <th> Action </th>
                </tr>
            </thead>
            <tbody id="table-body">
                <?php $total_registration_count = 0; $total_deposit_count = 0; $total_deposit_amount = 0; ?>
                <?php foreach ($leads as $index => $lead) { ?>
                    <tr>
                        <td> <?php echo ($index + 1) ?> </td>
                        <?php if (checkAuth(true)) { ?>
                            <td> <?php echo $lead->employees_name . ' : ' . $lead->username ?> </td>
                        <?php } ?>
                        <td> <?php echo $lead->campaign_name ?> </td>
                        <td> <?php echo $lead->state_name ?> </td>
                        <td> <?php echo ($lead->type == 0 ? 'Registration' : 'Deposit') ?> </td>
                        <td> <i class='bx bx-rupee mt-0'></i> <?php echo (int) $lead->total_lead_deposit ?> </td>
                        <td> <?php echo $lead->lead_date ?> </td>
                        <td>
                            <a href="/leads/edit/<?php echo $lead->id ?>" class="btn btn-info btn-sm">Edit</a>
                        </td>
                    </tr>
                    <?php
                        if ($lead->type == 0) $total_registration_count += 1;
                        else $total_deposit_count += 1;
                        $total_deposit_amount += $lead->total_lead_deposit;
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
                <span>Registrations: <b><?php echo $total_registration_count; ?></b></span>
            </li>
            <li class="nav-item lh-1 me-3">
                <span>Deposits: <b><?php echo $total_deposit_count; ?></b></span>
            </li>
            <li class="nav-item lh-1 me-3">
                <span>Deposits: <b><i class='bx bx-rupee mt-0'></i><?php echo $total_deposit_amount; ?></b></span>
            </li>
        </ul>
    </div>

<?php $customNavbar = ob_get_clean(); ?>

<?php ob_start(); ?>

<script>
    $('input[name="date"]').on('change', function (event) {
        window.location = "/leads/" + this.value;
    });
    $('select[name="state_id"]').on('change', function (event) {
        date = $('input[name="date"]').val();
        window.location = "/leads/" + date + "/" + this.value;
    });
</script>

<?php
    $customScript = ob_get_clean();
    include_once __DIR__."/../../layout/index.php";
?>
