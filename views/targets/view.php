<?php ob_start(); ?>
    <style>
        input[name=date] {
            width: initial;
            display: initial;
        }
    </style>
<?php $customStyle = ob_get_clean(); ?>

<?php ob_start(); ?>

<!-- <div>
  <canvas id="myChart"></canvas>
</div> -->

<div class="table-responsive text-nowrap">
    <table class="table table-hover">
        <thead>
            <tr class="text-nowrap">
                <th> # </th>
                <?php foreach ($states as $state) { ?>
                    <th> <?php echo $state->name ?> </th>
                <?php } ?>
            </tr>
        </thead>
        <tbody id="table-body">
            <?php foreach ($targets as $index => $target) { ?>
                <tr>
                    <td> <?php echo ($index + 1) ?> </td>
                    <?php foreach ($states as $state) { ?>
                        <th> <?php echo $state->code ?> </th>
                    <?php } ?>
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
        </ul>
    </div>

<?php $customNavbar = ob_get_clean(); ?>

<?php ob_start(); ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<!-- <script>
  const ctx = document.getElementById('myChart');
  Chart.register(ChartDataLabels);

  new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
            datalabels: {
                color: '#FFFFF'
            },
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 205, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(153, 102, 255, 0.2)',
            ],
            borderColor: [
                'rgb(255, 99, 132)',
                'rgb(255, 159, 64)',
                'rgb(255, 205, 86)',
                'rgb(75, 192, 192)',
                'rgb(54, 162, 235)',
                'rgb(153, 102, 255)',
            ],
            borderWidth: 1,
            stack: 'Stack 0',
        },
        {
            datalabels: {
                color: '#FFFFF'
            },
            label: '# of Votes22',
            data: [1, 19, 3, 5, 2, 3],
            borderWidth: 1,
            stack: 'Stack 0',
        }],
    },
    options: {
        x: {
            stacked: true,
        },
    },
  });
</script> -->
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
