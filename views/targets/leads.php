<?php ob_start(); ?>
    <style>
        input[type=date] {
            width: initial;
            display: initial;
        }

        th {
            font-weight: bolder;
            font-size: small !important;
        }

        #totals {
            table-layout: fixed;
            width: 40vw;
        }

        .right-line {
            border-right: 1.7px solid black;
        }

        .navbar-nav {
            gap: 1rem;
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
                        <th> Publisher </th>
                    <?php } ?>
                    <th> Campaign </th>
                    <th class="right-line"> State </th>
                    <th> Reg Made </th>
                    <th class="right-line"> Reg Tracked </th>
                    <th> Dep Made </th>
                    <th class="right-line"> Dep Tracked </th>
                </tr>
            </thead>
            <tbody id="table-body">
                <?php $registration_made = $registration_tracked = $deposit_made = $deposit_tracked = 0; ?>
                <?php foreach ($targets as $index => $target) { ?>
                    <tr>
                        <td> <?php echo ($index + 1) ?> </td>
                        <?php if (checkAuth(true)) { ?>
                            <td> <?php echo $target->employee_name ?> </td>
                        <?php } ?>
                        <td> <?php echo $target->campaign_name ?> </td>
                        <td class="right-line"> <?php echo $target->state_name ?? '-' ?> </td>
                        <td> <?php echo (int)$target->reg_made_count ?> </td>
                        <td class="right-line"> <?php echo (int)$target->reg_made_tracked_count ?> </td>
                        <td> <?php echo (int)$target->dep_made_count ?> </td>
                        <td class="right-line"> <?php echo (int)$target->dep_made_tracked_count ?> </td>
                    </tr>
                    <?php
                        $registration_tracked += (int)$target->reg_made_tracked_count;
                        $registration_made += (int)$target->reg_made_count;

                        $deposit_tracked += (int)$target->dep_made_tracked_count;
                        $deposit_made += (int)$target->dep_made_count;
                    ?>
                <?php } ?>
            </tbody>
        </table>
    </div>

<?php $customSection = ob_get_clean(); ?>

<?php ob_start(); ?>

    <div class="navbar-nav-left w-100">
        <ul class="navbar-nav align-items-center ms-auto">
            <li class="nav-item lh-1 me-10">
                <i class='bx bxs-calendar mt-0'></i>
                <span class="mt-2 me-2">From:</span>
                <input type="date" class="form-control" name="from_date" value="<?php echo $from_date; ?>">
            </li>
            <li class="nav-item lh-1 me-10">
                <i class='bx bxs-calendar mt-0'></i>
                <span class="mt-2 me-2">To:</span>
                <input type="date" class="form-control" name="to_date" value="<?php echo $to_date; ?>">
            </li>
            <!-- <li class="nav-item lh-1 d-flex flex-row me-10">
                <span class="mt-2 me-2">State:</span>
                <select name="state_id" class="form-select" required>
                        <option value=""> -- select state -- </option>
                        <?php foreach ($states as $state) { ?>
                            <option <?php echo ($state_id == $state->id) ? 'selected' : ''; ?> value="<?php echo $state->id; ?>"><?php echo $state->code . ' : ' . $state->name; ?></option>
                        <?php } ?>
                </select>
            </li> -->
            <li class="nav-item lh-1 me-10">
                <table id="totals">
                    <tr>
                        <td> <b>Registrations:</b> </td>
                        <td> <?php echo "Tracked: $registration_tracked" ?> </td>
                        <td> <?php echo "Made: $registration_made" ?> </td>
                    </tr>
                    <tr>
                        <td> <b>Deposits:</b> </td>
                        <td> <?php echo "Tracked: $deposit_tracked" ?> </td>
                        <td> <?php echo "Made: $deposit_made" ?> </td>
                    </tr>
                </table>
            </li>
        </ul>
    </div>

<?php $customNavbar = ob_get_clean(); ?>

<?php ob_start(); ?>

<script>
    $('input[type="date"]').on('change', function (event) {
        from_date = $('input[name="from_date"]').val();
        to_date = $('input[name="to_date"]').val();
        window.location = "/targets/leads/" + from_date + "/" + to_date;
    });
    /* $('select[name="state_id"]').on('change', function (event) {
        date = $('input[name="date"]').val();
        window.location = "/targets/leads/" + date + "/" + this.value;
    }); */
</script>

<?php
    $customScript = ob_get_clean();
    include_once __DIR__."/../../layout/index.php";
?>
