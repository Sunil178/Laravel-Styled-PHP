<?php ob_start(); ?>
    <style>
        input[name=date] {
            width: initial;
            display: initial;
        }

        .navbar-nav {
            gap: 1rem;
        }
    </style>
<?php $customStyle = ob_get_clean(); ?>

<?php ob_start(); ?>
    <div class="navbar-nav-left w-100">
        <ul class="navbar-nav align-items-center ms-auto">
            <li class="nav-item lh-1 me-10">
                <i class='bx bxs-calendar mt-0'></i>
                <span class="mt-2 me-2">Date:</span>
                <input type="date" class="form-control" name="date" value="<?php echo $date; ?>">
            </li>
            <li class="nav-item lh-1 me-10">
                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#newNumberModal">New Number</button>
            </li>
        </ul>
    </div>

<?php
    $customNavbar = ob_get_clean();
    ob_start();
?>


<div class="table-responsive text-nowrap">
    <table class="table table-hover">
        <thead>
            <tr class="text-nowrap">
                <th> # </th>
                <?php if (checkAuth(true)) { ?>
                    <th> Employee </th>
                <?php } ?>
                <th> Order ID </th>
                <th> Phone </th>
                <th> Price </th>
                <th> OTP </th>
                <th> Campaign </th>
                <th> Operator </th>
                <th> Date </th>
                <th> Status </th>
                <th> Action </th>
            </tr>
        </thead>
        <tbody id="table-body">
            <?php foreach ($sims as $index => $sim) { ?>
                <tr>
                    <td> <?php echo ($index + 1) ?> </td>
                    <?php if (checkAuth(true)) { ?>
                        <td> <?php echo $sim->employees_name ?> </td>
                    <?php } ?>
                    <td> <?php echo $sim->order_id ?> </td>
                    <td> <?php echo $sim->phone ?> </td>
                    <td> <?php echo $sim->price ?> </td>
                    <td> <?php echo $sim->otp ?> </td>
                    <td> <?php echo $sim->product_name ?> </td>
                    <td> <?php echo $sim->operator_name ?> </td>
                    <td> <?php echo $sim->created_at ?> </td>
                    <td> <?php echo $sim->status ?> </td>
                    <td>
                        <a href="/sims/<?php echo $sim->order_id ?>" class="btn btn-info btn-sm">View</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="newNumberModal" tabindex="-1" aria-labelledby="newNumberModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="newNumberModalLabel">New Number Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form method="POST" action="/sims/new" id="form">
                <div class="mb-3">
                    <label for="product_id" class="col-form-label">Product:</label>
                    <select name="product_id" id="product_id" class="form-select" required>
                            <option value=""> -- select product -- </option>
                            <?php foreach ($products as $product) { ?>
                                <option value="<?php echo $product->id; ?>"><?php echo $product->name; ?></option>
                            <?php } ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="operator_id" class="col-form-label">Operator:</label>
                    <select name="operator_id" id="operator_id" class="form-select" required>
                            <option value=""> -- select operator -- </option>
                            <?php foreach ($operators as $operator) { ?>
                                <option value="<?php echo $operator->id; ?>"><?php echo $operator->name; ?></option>
                            <?php } ?>
                    </select>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="document.getElementById('form').submit();">Buy</button>
        </div>
        </div>
    </div>
</div>

<?php $customSection = ob_get_clean(); ?>

<?php ob_start(); ?>

<script>
    $('input[name="date"]').on('change', function (event) {
        window.location = "/sims/" + this.value;
    });
</script>

<?php
    $customScript = ob_get_clean();
    include_once __DIR__."/../../layout/index.php";
?>
