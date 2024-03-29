<?php ob_start(); ?>
    <div class="w-100"></div>
<?php $customNavbar = ob_get_clean(); ?>

<?php
    ob_start();

    $model = new Model('employees');
    $employees = $model->getAll();
?>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr class="text-nowrap">
                    <th> # </th>
                    <th> Name </th>
                    <th> Username </th>
                    <th> Email </th>
                    <th> Mobile </th>
                    <th> Action </th>
                </tr>
            </thead>
            <tbody id="table-body">
                <?php foreach ($employees as $index => $employee) { ?>
                    <tr>
                        <td> <?php echo ($index + 1) ?> </td>
                        <td> <?php echo $employee->name ?> </td>
                        <td> <?php echo $employee->username ?> </td>
                        <td> <?php echo $employee->email ?> </td>
                        <td> <?php echo $employee->mobile ?> </td>
                        <td>
                            <a href="/employees/edit/<?php echo $employee->id ?>" class="btn btn-info btn-sm">Edit</a>
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
