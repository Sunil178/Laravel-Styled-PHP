<?php ob_start(); ?>

    <h1>Welcome <?php echo $_SESSION['employee_name'] ?? 'User' ?> To AceAffilino Tracker</h1>

<?php
    $customSection = ob_get_clean();
    include_once __DIR__."/layout/index.php";
?>
