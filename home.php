<?php ob_start(); ?>
    <div class="w-100"></div>
<?php $customNavbar = ob_get_clean(); ?>

<?php ob_start(); ?>

    <h1>Welcome <u><?php echo $_SESSION['employee_name'] ?? 'User' ?></u> To AceAffilino Tracker</h1>

<?php
    $customSection = ob_get_clean();
    include_once __DIR__."/layout/index.php";
?>
