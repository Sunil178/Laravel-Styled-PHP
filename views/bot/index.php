
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
                    <th> Android ID </th>
                    <th> Model </th>
                    <th> IPv4 </th>
                    <th> IPv6 </th>
                    <th> Proxy </th>
                    <th> Location </th>
                    <th> Tracking Link </th>
                    <th> Click Time </th>
                    <th> Install Time </th>
                    <th> Install Wait Time </th>
                </tr>
            </thead>
            <tbody id="table-body">
                <?php $total_rake = 0; ?>
                <?php foreach ($bot_leads as $index => $bot_lead) { ?>
                    <tr>
                        <td> <?php echo ($index + 1) ?> </td>
                        <td> <?php echo $bot_lead->android_id ?> </td>
                        <td> <?php echo $bot_lead->model ?> </td>
                        <td> <?php echo $bot_lead->ipv4 ?> </td>
                        <td> <?php echo $bot_lead->ipv6 ?> </td>
                        <td> <?php echo $bot_lead->proxy ?> </td>
                        <td> <?php echo $bot_lead->location ?> </td>
                        <td> <?php echo $bot_lead->tracking_link ?> </td>
                        <td> <?php echo $bot_lead->click_time ?> </td>
                        <td> <?php echo $bot_lead->install_time ?> </td>
                        <td> <?php echo $bot_lead->install_wait_time ?> </td>
                    </tr>
                    <?php $total_rake += $bot_lead->rake; ?>
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
        </ul>
    </div>
<?php $customNavbar = ob_get_clean(); ?>

<?php ob_start(); ?>

<script>
    $('input[name="date"]').on('change', function (event) {
        window.location = "/bot/index/" + this.value;
    });
</script>

<?php
    $customScript = ob_get_clean();
    include_once __DIR__."/../../layout/index.php";
?>
